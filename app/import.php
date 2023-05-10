<?php
error_reporting(E_ERROR | E_PARSE);
// ===== Configuration =====
// API
const API_SCHEMA = "https"; // const API_SCHEMA = "http";
const API_HOST = "api.mesoc.dev"; // const API_ROOT = "localhost:8000";
const API_URL = API_SCHEMA . "://" . API_HOST;

const API_KEY = "4efda293b6becbfa61d29b5b7c819ebe2991e5c1";
const API_ENDPOINT = "/export/documents/";

// Database
const DB_DRIVER = "mysql";
const DB_HOST = "127.0.0.1";
const DB_NAME = "mesoctest";
const DB_USER = "mesoc";
const DB_PASSWORD = "Fueth8ph!";
const DB_DSN = DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME;

// File upload
const UPLOAD_DIR = "/waitingroom"; // exclude trailing /
// ===== End of configuration =====

function getDataFromAPI($token, $endpoint) {
    $url = API_URL . $endpoint;

    $opts = array(
        "http" => array(
            "method" => "GET",
            "header" => "Authorization: Bearer " . $token . "\n"
        )
    );
    
    $context = stream_context_create($opts);

    $data = file_get_contents($url, false, $context);
    
    if($data === false)
        throw new RuntimeException("API call did not succeed.");
        
    return [$data, $http_response_header];
}

function getDocumentsFromAPI($token) {
    $endpoint = API_ENDPOINT;
   
    try {
        $data = getDataFromAPI($token, $endpoint)[0];
    }
    catch(RuntimeException $e) {
        echo $e->getMessage();
        die();
    }
   
    return json_decode($data);
}

function getPDFFromAPI($token, $documentId) {
    $endpoint = API_ENDPOINT . $documentId . "/file/";
    
    try {
        $data = getDataFromAPI($token, $endpoint);
    }
    catch(RuntimeException $e) {
        echo $e->getMessage();
        die();
    }
    
    $matches = array();
    foreach($data[1] as $index => $header) {
        if(preg_match("/^Content-Disposition/", $header)) {
            preg_match("/filename=\"(.+)\"/", $header, $matches);
        }
    }
        
    return [$data[0], $matches[1]];
}

function mapCategory($value, $categories) {
    $dataMapping = array(
        "scientific" => "Scientific paper",
        "pilot" => "Case study"
    );
    
    foreach($categories as $cat) {
        if($cat->name == $dataMapping[$value]) {
            return $cat;
        }
    }
}

function mapLanguage($value, $languages) {
    // Find matching or return "Other" language;

    $other = null;
    foreach($languages as $lang) {
        if($lang->language == $value) {
            return $lang;
        }
        else {
            if($other == null && $lang->language == "Other") {
                $other = $lang;
            }
        }
    }
    
    return $other;   
}

function mapCulturalDomain($value, $domains) {
    $dataMapping = array(
        "Heritage",
        "Archives",
        "Libraries",
        "Book and Press",
        "Visual Arts",
        "Performing Arts",
        "Audiovisual and Multimedia",
        "Architecture",
        "Advertising",
        "Art crafts"
    );
    
    foreach($domains as $domain) {
        if($domain->name == $dataMapping[$value]) {
            return $domain;
        }
    }
}

function mapSocialImpacts($value, $socialImpacts) {
    $dataMapping = array(
        "Health and Wellbeing",
        "Urban and Territorial Renovation",
        "People&#39;s Engagement and Participation"
    );
    
    foreach($socialImpacts as $socImpact) {
        if($socImpact->name == $dataMapping[$value]) {
            return $socImpact;
        }

    }
}

function mapCity($value, $cities) {
    // Find matching or return "------" city;
    $value = ucwords($value);

    $other = null;
    foreach($cities as $city) {
        if($city->CityName == $value) {
            return $city;
        }
        else {
            if($other == null && $city->CityName == "------") {
                $other = $city;
            }
        }
    }
    
    return $other;   
}

$documents = getDocumentsFromAPI(API_KEY);

try {
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
}
catch(PDOException $e) {
    echo $e->getMessage();
    die();
}


$sql = "SELECT ID_Category id, CategoryName name FROM category;";
$statement = $pdo->query($sql);

$docCategories = $statement->fetchAll(PDO::FETCH_OBJ);
if(!$docCategories)
    die();
    
$sql = "SELECT Language, ID_Language FROM language;";
$statement = $pdo->query($sql);

$docLanguages = $statement->fetchAll(PDO::FETCH_KEY_PAIR);
if(!$docLanguages)
    die();
    
$sql = "SELECT ID_CultDomain id, CultDomainName name FROM culturaldomain;";
$statement = $pdo->query($sql);

$docDomains = $statement->fetchAll(PDO::FETCH_OBJ);
if(!$docDomains)
    die();

$sql = "SELECT ID_SocImpact id, SocImpactName name FROM socialimpact;";
$statement = $pdo->query($sql);

$docSocImpacts = $statement->fetchAll(PDO::FETCH_OBJ);
if(!$docDomains)
    die();
    
$sql = "SELECT CityName name, ID_City id FROM city";
$statement = $pdo->query($sql);

$docCities = $statement->fetchAll(PDO::FETCH_KEY_PAIR);
if(!$docCities)
    die();

    
$sql = "SELECT CountryName name, ID_Country id FROM country WHERE CountryName <> '-----';";
$statement = $pdo->query($sql);

$docCountries = $statement->fetchAll(PDO::FETCH_KEY_PAIR);
if(!$docCountries)
    die();
   

$sql = "SELECT uuid, id FROM importeddocument;";
$statement = $pdo->query($sql);
$existing = $statement->fetchAll(PDO::FETCH_KEY_PAIR);

foreach($documents as $doc) {
    if(array_key_exists($doc->id, $existing))
        continue;

    $title = $doc->title;
    $summary = $doc->abstract;
    // $category = mapCategory($doc->type, $docCategories);
    
    $keywords = "";
    $strlen = 0;
    $keywordNum = 0;
    foreach($doc->keywords as $keyword) {
        $strlen += strlen($keyword);
        // keywords db field size = 1000
        if($strlen > 1000 - $keywordNum) {
            break;
        }
        
        $keywordNum++;
    }
    $keywords = implode("|", array_slice($doc->keywords, 0, $keywordNum));
   
    $countryName = strtoupper($doc->location->country);
    $country = null;
    if(!array_key_exists($countryName, $docCountries)) {
        $sql = "INSERT INTO country(CountryName) VALUES(?);";
        $statement = $pdo->prepare($sql);
        $statement->execute([$countryName]);
        
        $sql = "SELECT ID_Country id, CountryName name FROM country WHERE CountryName = '$countryName';";
        $statement = $pdo->query($sql);
        $country = $statement->fetch(PDO::FETCH_OBJ);
        $docCountries[$countryName] = $country;
    }
    else {
        $country = $docCountries[$countryName];
    }
    
    $city = null;
    if($doc->location->city != "" && !array_key_exists($doc->location->city, $docCities)) {
        $sql = "INSERT INTO city(CityName, LATITUDE, LONGITUDE, ID_Country) VALUES(?, ?, ?, ?);";
        $statement = $pdo->prepare($sql);
        $statement->execute([$doc->location->city, $doc->location->latitude, $doc->location->longitude, $country->id]);
        
        $sql = "SELECT ID_City id, CityName name, LATITUDE latitude, LONGITUDE longitude FROM city WHERE CityName = '" . $doc->location->city . "';";
        $statement = $pdo->query($sql);
        $city = $statement->fetch(PDO::FETCH_OBJ);
        
        $docCities[$city->name] = $city->id;
    }
    else {
        $city = $docCities[$doc->location->city];
    }

    $language = null;
    if(!array_key_exists($doc->language->name, $docLanguages)) {
        $sql = "INSERT INTO language(Language) VALUES(?);";
        $statement = $pdo->prepare($sql);
        $statement->execute([$doc->language->name]);
        
        $sql = "SELECT ID_Language id, Language language FROM language WHERE Language = '" . $doc->language->name . "';";
        $statement = $pdo->query($sql);
        $language = $statement->fetch(PDO::FETCH_OBJ);
        
        $docLanguages[$language->name] = $language->id;
    }
    else {
        $language = $docLanguages[$doc->language->name];
    }
    
    $socImpacts = array();
    $domains = array();
    foreach($doc->cells as $cell) {
        $impact = mapSocialImpacts($cell->cell_2d[1], $docSocImpacts);
        $domain = mapCulturalDomain($cell->cell_2d[0], $docDomains);
        
        if(!in_array($impact->name, $socImpacts))
            $socImpacts[] = $impact->name;
        
        if(!in_array($domain->name, $domains))
            $domains[] = $domain->name;
    }

    $socImpacts = implode("|", $socImpacts);
    $domains = implode("|", $domains);

    $variables = array(0 => array(), 1 => array(), 2 => array());
    $variable_keywords = array(0 => array(), 1 => array(), 2 => array());
    foreach($doc->impacts as $variable) {
        $variables[$variable->column][] = $variable->impact;
        $variable_keywords[$variable->column][] = implode("~", $variable->keywords);
    }
    $variables0 = implode("#", $variables[0]);
    $variables0_keywords = implode("#", $variable_keywords[0]);
    $variables1 = implode("#", $variables[1]);
    $variables1_keywords = implode("#", $variable_keywords[1]);
    $variables2 = implode("#", $variables[2]);
    $variables2_keywords = implode("#", $variable_keywords[2]);
    
    $variables_db = implode("|", array($variables0, $variables1, $variables2));
    $variable_keywords_db = implode("|", array($variables0_keywords, $variables1_keywords, $variables2_keywords));
    
    echo $variables_db . "\n";
    
    $pdf = getPDFFromAPI(API_KEY, $doc->id);
    
    $pdfPath = UPLOAD_DIR . "/" . $pdf[1];
    $handle = fopen($pdfPath, "wb");
    fwrite($handle, $pdf[0]);
    fclose($handle);

    $sql = "INSERT INTO documentwaitingroom(title, summary, keywords, ID_Language, ID_Category, socimpacts, culturaldomains, transitionvar, keywordtv, city) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $statement = $pdo->prepare($sql);
    $statement->execute([$title, $summary, $keywords, $language, $category->id, $socImpacts, $domains, $variables_db, $variable_keywords_db, $city]);
    
    $sql = "INSERT INTO importeddocument(uuid, ID_WaitingRoom, file) VALUES(?, ?, ?);";
    $statement = $pdo->prepare($sql);
    $statement->execute([$doc->id, $pdo->lastInsertId(), $pdfPath]);
}
?>
