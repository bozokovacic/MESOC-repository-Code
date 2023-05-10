<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlConnection;

/**
 * ProductsController
 *
 * Manage CRUD operations for documents
 */
class DocumentController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Documents');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new DocumentForm;
    }

/**    public function readAction() {
   
        if(isset($_POST['import'])) {

        if((isset($_FILES['file']) && is_array( $_FILES['file']))) {

            $csv = $_FILES['file'];
 
            if(isset($csv['tmp_name']) && !empty($csv['tmp_name'])) {

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $csv['tmp_name']);
                finfo_close($finfo);

                $allowed_mime = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

                if(in_array($mime, $allowed_mime) && is_uploaded_file($csv['tmp_name'])) {

                    $f = fopen($csv['tmp_name'], 'r');

                    fgetcsv($f);

                    $data = array();

                    while($row = fgetcsv($f)) {
                        $name = $row[0];
                        $age = $row[1];
                        array_push($data, array($name, $age));
                    }

                fclose($f);

                echo '<pre>';
                var_dump($data);
                echo '<pre>';
                die;
            }
         }
       }
     }
    } */
            
    /**
     * Pregled svojstava document
     */
    public function pregledAction($ID_Doc){
        
        $numberPage = 1;
        
        $document = $this->dispatcher->getParam("document");
        
        $document = Document::findFirst(" ID_Doc = '$ID_Doc'");
        
        $docview= '';
        $ID_Category = $document->ID_Category;

	$doctransitionvar = Doctransitionvar::find(" ID_Doc = '$ID_Doc'");
             
        if (count($doctransitionvar) > 0) {
            $docview .= ' <H4>TRANSITION VARIABLE</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                      .'<thead><tr><th>CROSS OVER THEME</th><th>TRANSITION VARIABLE</th><th>KEYWORD TRANSITION VARIABLE</th></tr></thead><tbody><tr>';
       
//                $doctransitionvar = "SELECT TV.ID_Transvar,TV.TransvarName, TS.ID_SocImpact FROM transitionvar TV INNER JOIN doctransitionvar DT ON TV.ID_Transvar = DT.ID_Transvar INNER JOIN transitionvarsocialimpact TS ON TV.ID_Transvar = TS.ID_Transvar WHERE DT.ID_Doc = $ID_Doc ORDER by TS.ID_SocImpact ";                        
                $doctransitionvar = "SELECT TV.ID_Transvar,TV.TransvarName, DT.ID_SocImpact FROM transitionvar TV INNER JOIN doctransitionvar DT ON TV.ID_Transvar = DT.ID_Transvar WHERE DT.ID_Doc = $ID_Doc ORDER by DT.ID_SocImpact "; 
                $resultGeneral = $this->db->query($doctransitionvar);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral);                     
                
                foreach ($resultGeneral as $row => $result) {
                    
                    $ID_Tranvsar = $result['ID_Transvar'];
                    $TranvsarName = $result['TransvarName'];
                                        
                    if ( $result['ID_SocImpact'] == 1 ) $tranvarsector = "H&W"; 
                    if ( $result['ID_SocImpact'] == 2 ) $tranvarsector = "U&TR"; 
                    if ( $result['ID_SocImpact'] == 3 ) $tranvarsector = "PE&P"; 
                    if ( $result['ID_SocImpact'] == 63 ) $tranvarsector = "G&S&I";
   
                    $transvarkeywordtv = "SELECT K.KeywordtvName FROM keywordtv K INNER JOIN transitionvarkeywordtv TK ON TK.ID_Keywordtv = K.ID_keywordtv WHERE TK.ID_Doc = $ID_Doc AND TK.ID_Transvar = $ID_Tranvsar ";                        

                    $resultGeneral2 = $this->db->query($transvarkeywordtv);
                    $resultGeneral2->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                    $resultGeneral2 = $resultGeneral2->fetchAll($resultGeneral2);                      
                    $n = 1;

                    foreach ($resultGeneral2 as $row => $result2) {
                        if ( $n == 1) {
                            $docview .= '<td>'.$tranvarsector.'</td><td>'.$TranvsarName.'</td><td>'.$result2['KeywordtvName'].'</td></tr>';
                            $n++;
                        }else {
                        $docview .= '<td></td><td></td><td>'.$result2['KeywordtvName'].'<BR></td></tr>';    
                        }        
                    }
                 }
       
            $docview .=  '</tbody></table>';
          
        }

        $upload = Upload::find(" ID_Doc = '$ID_Doc'");
             
        if (count($upload) > 0) {
            
            $docview .= ' <H4>DOCUMENT UPLOADS</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>UPLOAD USER NAME</th><th>FILE SIZE</th><th>FILE TYPE</th><th>DOWNLOAD</th></tr></thead><tbody><tr>';
                
                foreach ($upload as $upload_data) {
                    
                    $UserFileName = $upload_data->UserFileName;
                    $FileName = $upload_data->FileName;
                    $FileSize = $upload_data->FileSizeKB;
                    $FileType = $upload_data->FileType;
                    $Download = $upload_data->Download;
                    $docview .= '<td>'.$UserFileName.'</td><td>'.$FileSize.'</td><td>'.$FileType.'</td><td>'.$Download.'</td>';
//                    $docview .= '</td><td> {{link_to("../uploads/"'.$FileName.', <i class="glyphicon glyphicon-download"></i> Download, "class": "btn btn-default") }}'.'</td></tr>';
                    $docview .= '</td><td><a target = "_blank" href="/../uploads/'.$FileName.'" class="btn btn-default"><i class="glyphicon glyphicon-download"></i> Download</a></td></tr>';
//                    $docview .= '</td><td><a href="../uploads/"'.$FileName.'" class="btn btn-default" <i class="glyphicon glyphicon-download"></i> Download</a></td></tr>';                    
                 }
       
            $docview .=  '</tbody></table>';

        }

        
        $documentcultldomain = Documentculturaldomain::find(" ID_Doc = '$ID_Doc'");
             
        if (count($documentcultldomain) > 0) {
            
            $docview .= ' <H4>CULTURAL SECTOR</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>CULTURAL SECTOR</th></tr></thead><tbody><tr>';
       
                $doccultdomain = "SELECT CD.CultDomainName FROM documentculturaldomain DC INNER JOIN culturaldomain CD ON CD.ID_CultDomain = DC.ID_CultDomain WHERE DC.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($doccultdomain);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['CultDomainName'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';

        }
        
        $documentsocimpact = Documentsocialimpact::find(" ID_Doc = '$ID_Doc'");
             
        if (count($documentsocimpact) > 0) {
            
            $docview .= ' <H4>CROSS-OVER THEME</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>CROSS-OVER THEME</th></tr></thead><tbody><tr>';
       
                $docsocimpact = "SELECT SC.SocImpactName FROM documentsocialimpact DS INNER JOIN socialimpact SC ON SC.ID_SocImpact = DS.ID_SocImpact WHERE DS.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($docsocimpact);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['SocImpactName'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';

        }
        
        $docauthor = Docauthor::find(" ID_Doc = '$ID_Doc'");
             
        if (count($docauthor) > 0) {
            
            $docview .= ' <H4>AUTHORS</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>LAST NAME</th><th>FIRST NAME</th></tr></thead><tbody><tr>';
       
                $author = "SELECT A.FirstName, A.LastName, C.CountryName, I.InstName FROM docauthor DA INNER JOIN author A ON DA.ID_Author = A.ID_Author INNER JOIN country C ON DA.ID_Country = C.ID_Country INNER JOIN institution I ON DA.ID_Institution = I.ID_Institution WHERE DA.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($author);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['LastName'].'</td><td>'.$result['FirstName'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';
            
        }
        
        $doccountry = Doccountry::find(" ID_Doc = '$ID_Doc'");
             
        if (count($doccountry) > 0) {
            
            $docview .= ' <H4>NUTS CODE</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>COUNTRY CODE</th><th>COUNTRY</th><th>REGION</th><th>CITY</th><th>TERR. CONTEXT</th>'.
                    '</tr></thead><tbody>';
                
                $query = "SELECT R.RegionName, C.CountryCode, C.CountryName, CT.CityName, DC.TeritCon FROM doccountry DC INNER JOIN city CT ON DC.ID_City = CT.ID_City INNER JOIN country C ON DC.ID_Country = C.ID_Country INNER JOIN region R ON DC.ID_Region = R.ID_Region WHERE DC.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['CountryCode'].'</td><td>'.$result['CountryName'].'</td><td>'.$result['RegionName']. '</td><td>'.$result['CityName']. '</td><td>'.$result['TeritCon'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';
                     
        }
  
        $docsearchdatabase = Docsearchdatabase::find(" ID_Doc = '$ID_Doc'");
             
        if (count($docsearchdatabase) > 0) {
            
            $docview = $docview.' <H4>SEARCH DATABASE</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>SEARCH DATABASE</th></tr></thead><tbody>';
                    
                $query = "SELECT SD.SearchDatabase FROM docsearchdatabase DS INNER JOIN searchdatabase SD ON DS.ID_Database = SD.ID_Database WHERE DS.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['SearchDatabase'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';    
        }    
        
        $doctechnique = Doctechnique::find(" ID_Doc = '$ID_Doc'");
             
        if (count($doctechnique) > 0) {
            
               
            $docview = $docview.' <H4>TECHNIQUE</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>TECHNIQUE</th></tr></thead><tbody>';
                    
                $query = "SELECT T.TechniqueName FROM doctechnique DT INNER JOIN technique T ON DT.ID_Technique = T.ID_Technique WHERE DT.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['TechniqueName'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';  
        }    
        
        $doclitarea = Doclitarea::find(" ID_Doc = '$ID_Doc'");
        
        if (count($doclitarea) > 0) {
            
             $docview = $docview.' <H4>LITERATURE AREA</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>LITERATURE AREA</th></tr></thead><tbody>';
                    
                $query = "SELECT L.LiteratureArea FROM doclitarea DL INNER JOIN litarea L ON DL.ID_LitArea = L.ID_LitArea WHERE DL.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['LiteratureArea'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';  
            
        }
        
        $docdataprov = Docdataprov::find(" ID_Doc = '$ID_Doc'");
        
        if (count($docdataprov) > 0) {
            
               $docview = $docview.' <H4>DATA PROVIDER AREA</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>DATA PROVIDER</th></tr></thead><tbody>';
                    
                $query = "SELECT DP.DataProvName FROM docdataprov DDP INNER JOIN dataprov DP ON DDP.ID_DataProv = DP.ID_DataProv WHERE DDP.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['DataProvName'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';  
            
        }
        
        $docsector = Docsector::find(" ID_Doc = '$ID_Doc'");
        
        if (count($docsector) > 0) {
            
            $docview = $docview.' <H4>SECTOR</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                .'<thead><tr><th>SECTOR</th></tr></thead><tbody>';
                    
                $query = "SELECT S.SectorName FROM docsector DS INNER JOIN sector S ON DS.ID_Sector = S.ID_Sector WHERE DS.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['SectorName'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';  
            
        }
              
        $docinstitution = Docinstitution::find(" ID_Doc = '$ID_Doc'");
        
        if (count($docinstitution) > 0) {
            
            $docview = $docview.' <H4>INSTITUTION</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                .'<thead><tr><th>INSTITUTION</th><th>COUNTRY</th></tr></thead><tbody>';
                    
                $query = "SELECT I.InstName, I.ID_Country FROM docinstitution DI INNER JOIN institution I ON DI.ID_Institution = I.ID_Institution WHERE DI.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 

                foreach ($resultGeneral as $row => $result) {
                    $ID_Country  = $result['ID_Country'];
                    $country = Country::findFirst(" ID_Country = '$ID_Country'");
                    $CountryName = $country->CountryName;
                    $docview .= '<td>'.$result['InstName'].'<td>'.$CountryName.'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';  
        }

        $doccity = Doccity::find(" ID_Doc = '$ID_Doc'");
        
        if (count($doccity) > 0) {
            
            $docview = $docview.' <H4>TERRITORIAL CONTEXT</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                .'<thead><tr><th>CITY</th><th>COUNTRY</th></tr></thead><tbody>';
                    
                $query = "SELECT C.CityName, C.ID_Country FROM doccity DC INNER JOIN city C ON DC.ID_City = C.ID_City WHERE DC.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 

                foreach ($resultGeneral as $row => $result) {
                    $ID_Country  = $result['ID_Country'];
                    $country = Country::findFirst(" ID_Country = '$ID_Country'");
                    $CountryName = $country->CountryName;
                    $docview .= '<td>'.$result['CityName'].'<td>'.$CountryName.'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';  
        }

        $document->docview = $docview;
        
//        $this->view->document  = $document;
        
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }
        }
        // DOCUMENT 
        $document = Document::findFirst(" ID_Doc = '$ID_Doc'");
        if (count($document) == 0) {
            $this->flash->notice("Document not found");
        }
        
	if ($this->session->has("View")) {
            $View = $this->session->get("View");
        }

        $document->DOI =  '<a href="https://doi.org/'.$document->DOI.'" target="_blank">'.$document->DOI.'</a>';
        
        $this->view->document  = $document;
        
        $paginator = new Paginator(array(
            "data"  => $document,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();
	$this->view->setVar('ID_Category', $ID_Category);
	$this->view->setVar('View', $View);
            
    }

    /**
     * Search document based on current criteria
     */
    public function searchAction()
    {
        if ($this->session->has("auth")) {
            // Retrieve its value
            $auth = $this->session->get("auth");
        }
        $ID_Role = $auth['ID_Role'];
        $this->session->set("role", "$ID_Role");
	$View = 'SEARCH';
        $this->session->set("View", "$View");  
              
        $numberPage = 1;

        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Document", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
	    if ( $numberPage == NULL) {
	        $numberPage = $this->session->get("numberPage");
	    } else {
		$this->session->set("numberPage", "$numberPage");
            }
        }


        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $document = Document::find($parameters);
        if (count($document) == 0) {
            $this->flash->notice("Document not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator(array(
            "data"  => $document,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
	$this->view->setVar('Role', $ID_Role);
	$this->view->setVar('View', $View);

    }

      public function viewAction()
    {
        $numberPage = 1;
             
        $document = Document::find($parameters);  

         if ($this->session->has("auth")) {
            // Retrieve its value
            $auth = $this->session->get("auth");
        }
        $ID_Role = $auth['ID_Role'];
        $this->session->set("ID_Role", "$ID_Role");
	$View = 'ALL';
        $this->session->set("View", "$View");  

        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Document", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
	    if ( $numberPage == NULL) {
	        $numberPage = $this->session->get("numberPage");
	    } else {
		$this->session->set("numberPage", "$numberPage");
            }
        }
        
        $document = Document::find(
                [
                'order'      => 'ID_Doc',   
                ]);  
        
        if (count($document) == 0) {
            $this->flash->notice("Document not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator(array(
            "data"  => $document,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
	$this->view->setVar('Role', $ID_Role);
	$this->view->setVar('View', $View);

    }
    
    /**
     * Shows the form to create a new document
     */
    public function newAction($ID_Category)
    {
       if ($this->session->has("ID_Role")) {
          $ID_Role = $this->session->get("ID_Role");
          $this->session->set("ID_Category", "$ID_Category");
        }   
// echo $ID_Role.' - '.$ID_Category.'<BR>';
        
        if ( ($ID_Role == 4) && ($ID_Category == 2 )) $this->view->form = new DocumentFullForm(null, array('edit' => true, 'ID_Category' => $ID_Category));
        if ( ($ID_Role == 4) && ($ID_Category = 1 )) $this->view->form = new DocumentFullForm(null, ['edit' => true,'ID_Category' => $ID_Category]);
        if ( ($ID_Role == 4) && ($ID_Category = 3 )) $this->view->form = new DocumentcasestudyForm(null, ['edit' => true,'ID_Category' => $ID_Category]);
        if ( ($ID_Role == 3) && ($ID_Category != 2 )) $this->view->form = new DocumentcasestudyForm(null, ['edit' => true,'ID_Category' => $ID_Category]);    }

    /**
     * Edits a document based on its id
     */
    public function editAction($ID_Doc)
    {

        $document = $this->dispatcher->getParam("document");
        
	$this->session->set("ID_Doc", "$ID_Doc");

	if ($this->session->has("ID_Role")) {
            $ID_Role = $this->session->get("ID_Role");
            $ID_Category = $this->session->get("ID_Category");
        }   

        if (!$this->request->isPost()) {

            $document = Document::findFirst("ID_Doc = '$ID_Doc'");
	    $ID_Category = $document->ID_Category;

            if (!$document) {
                $this->flash->error("Document not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                );
            }

//            $this->view->form = new DocumentFullForm($document, array('edit' => true));
            if ( ($ID_Role == 4) && ($ID_Category == 1 )) $this->view->form = new DocumentFullForm($document, array('edit' => true, 'ID_Category' => $ID_Category));
            if ( ($ID_Role == 4) && ($ID_Category == 2 )) $this->view->form = new DocumentFullForm($document, array('edit' => true, 'ID_Category' => $ID_Category));
            if ( ($ID_Role == 4) && ($ID_Category == 3 )) $this->view->form = new DocumentcasestudyForm($document, array('edit' => true, 'ID_Category' => $ID_Category));
            if ( ($ID_Role == 3) && ($ID_Category == 3 )) $this->view->form = new DocumentcasestudyForm($document, array('edit' => true, 'ID_Category' => $ID_Category));

        }
    }

    public function unosAction()
    {
        
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "index",
                ]
            );
        }

//        $form = new DocumentFullForm;
        $document = new Document();

        $data = $this->request->getPost();
// die(var_dump($data));
        
        $ID_Doc = $data['broj'];
//        echo $ID_Doc;
        $doc = Doc::findFirst("ID_Doc = '$ID_Doc'");
         
            $document->PubYear = $doc->PubYear;
            $document->Title = $doc->Title;
            $document->BiblioRef = $doc->BiblioRef;
            $document->ID_Type = $doc->ID_Type;
            $document->ID_Language = $doc->ID_Language;
            $document->NumPages = $doc->NumPages;
            $document->Links = $doc->Links;
            $document->Summary = $doc->Summary;
            $document->PeriodFrom = $doc->PeriodFrom;
            $document->Methodology = $doc->Methodology;
            $document->Technique = $doc->Technique;
            $document->DataProviders = $doc->DataProviders;
            $document->FindingOutcomes = $doc->FindingOutcomes;
            $document->Keywords = $doc->Keywords;
            $document->Relevance = $doc->Relevance;
            $document->Searchdatabase = $doc->Searchdatabase;
            $document->OpenAccess = $doc->OpenAccess;
	    $institution = $doc->Institution; 
            $inst = str_replace(","," -",$institution);
            $document->Institution = $inst;
            $author = $doc->Author; 
            $author = str_replace(",",";",$author);
            $author = str_replace(" ",", ",$author);
            $author = str_replace(";, ","; ",$author);       
            $document->Author = $author;
            $document->DOI = $doc->DOI;
            $document->ID_Category = 2;
/*        die(var_dump($doc)); 
        die(var_dump($document)); */
        
          $DocTitle = strtolower($document->Title);
      
        $document_all = Document::find();
        $i = 0;
        
        foreach ( $document_all as $doc_all ) {
            
            $title = strtolower($doc_all->Title);
            if ( $title == $DocTitle ) {
               $i = 1;
               $Doc = $doc_all->ID_Doc;
               break;
            }
        }
//        die(var_dump($document_all));
        if ( $i == 1 ) {
            
            $message1 = 'The document is stored with ID: '.$Doc;
             $this->flash->error($message1);
             
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "view",
                    ]
                );
            } else {
              
            if ($document->save() == false) {
                foreach ($document->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "new",
                    ]
                );
            }

            $this->flash->success("Document is created.");
        
        return $this->dispatcher->forward(
            [
                "controller" => "document",
                "action"     => "index",
            ]
        );
      }  
    }


    /**
     * Creates a new document
     */
    public function createAction()
    {

	 if ($this->session->has("ID_Category")) {
            $ID_Category = $this->session->get("ID_Category");
         }   

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "index",
                ]
            );
        }

	$Create = 0;            
        $this->session->set("Create", "$Create");

        if ( $ID_Category == 1 ) $form = new DocumentFullForm();
        if ( $ID_Category == 2 ) $form = new DocumentFullForm();
        if ( $ID_Category == 3 ) $form = new DocumentcasestudyForm();
        if ( $ID_Category == 4 ) $form = new DocumentcasestudyForm();

//        $form = new DocumentFullForm;
        $document = new Document();

        $data = $this->request->getPost();
//die(var_dump($data));
        if (!$form->isValid($data, $document)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

     	    if ( ($ID_Role == 4) && ($ID_Category == 1 )) $this->view->form = new DocumentFullForm($document, array('edit' => true, 'ID_Category' => $ID_Category));
     	    if ( ($ID_Role == 4) && ($ID_Category == 2 )) $this->view->form = new DocumentFullForm($document, array('edit' => true, 'ID_Category' => $ID_Category));
            if ( ($ID_Role == 4) && ($ID_Category == 3 )) $this->view->form = new DocumentcasestudyForm($document, array('edit' => true, 'ID_Category' => $ID_Category));
            if ( ($ID_Role == 3) && ($ID_Category == 3 )) $this->view->form = new DocumentcasestudyForm($document, array('edit' => true, 'ID_Category' => $ID_Category));       
     
            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "new",
                ]
            );
        }

        $DocTitle = strtolower($document->Title);
      
        $document_all = Document::find();
        $i = 0;
        
        foreach ( $document_all as $doc_all ) {
            
            $title = strtolower($doc_all->Title);
            if ( $title == $DocTitle ) {
               $i = 1;
               $Doc = $doc_all->ID_Doc;
               break;
            }
        }
//        die(var_dump($document_all));
        if ( $i == 1 ) {
            
            $message1 = 'The document is stored with ID: '.$Doc;
             $this->flash->error($message1);
             
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "view",
                    ]
                );
            } else {
              
            if ($document->save() == false) {
                foreach ($document->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "new",
                    ]
                );
            }

            $form->clear();

            $this->flash->success("Document is created.");
        
        return $this->dispatcher->forward(
            [
                "controller" => "document",
                "action"     => "index",
            ]
        );
      }  
    }

/**    public function newreadAction()
    {
        $this->view->form = new ReadFileForm(null, array('edit' => true));
    }

    public function readfileAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "index",
                ]
            );
        }

        $form = new DocumentFullForm;
        $document = new Document();

        $data = $this->request->getPost();
        die(var_dump($data));
        if (!$form->isValid($data, $document)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "new",
                ]
            );
        }

        $DocTitle = strtolower($document->Title);
      
        $document_all = Document::find();
        $i = 0;
        
        foreach ( $document_all as $doc_all ) {
            
            $title = strtolower($doc_all->Title);
            if ( $title == $DocTitle ) {
               $i = 1;
               $Doc = $doc_all->ID_Doc;
               break;
            }
        }
//        die(var_dump($document_all));
        if ( $i == 1 ) {
            
            $message1 = 'The document is stored with ID: '.$Doc;
             $this->flash->error($message1);
             
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "view",
                    ]
                );
            } else {
              
            if ($document->save() == false) {
                foreach ($document->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "new",
                    ]
                );
            }

            $form->clear();

            $this->flash->success("Document is created.");
        
        return $this->dispatcher->forward(
            [
                "controller" => "document",
                "action"     => "index",
            ]
        );
      }  
    } */

    /**
     * Saves current document
     *
     * @param string $id
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "index",
                ]
            );
        }

 	if ($this->session->has("ID_Doc")) {
            // Retrieve its value
                $ID_Doc = $this->session->get("ID_Doc");
                $Create = $this->session->get("Create");
            }   
         
        if ( $Create == 0 ) {
            $ID_Doc = $this->request->getPost("ID_Doc", "string");
        } else {
               $Create = 0; 
            $this->session->set("ID_Doc", "$ID_Doc");
            $this->session->set("Create", "$Create");
        }     
   
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
	$ID_Category = $document->ID_Category;

        if (!$document) {
            $this->flash->error("Document not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "index",
                ]
            );
        }

//        $form = new DocumentFullForm;
	if ( $ID_Category == 1 ) $form = new DocumentFullForm();
	if ( $ID_Category == 2 ) $form = new DocumentFullForm();
        if ( $ID_Category == 3 ) $form = new DocumentcasestudyForm();
        if ( $ID_Category == 4 ) $form = new DocumentcasestudyForm();
        $this->view->form = $form;

        $data = $this->request->getPost();

        if (!$form->isValid($data, $document)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "edit",
                ]
            );
        }
          
        $auth = $this->session->get('auth');

        $ID_User = $auth['id'];
        $ID_Role = $auth['ID_Role'];
        $ID_Partner = $auth['ID_Partner'];
        $document->ID_User = $ID_User;
        $document->ID_Role = $ID_Role;
        $document->ID_Partner = $ID_Partner;
        
          if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "edit",
                ]
            );
          }

            $form->clear();

            $this->flash->success("Document updated.");
                
            $docinstitution = Docinstitution::find("ID_Doc = '$ID_Doc'");      
// die(var_dump($docinstitution));
            $i = 0;
            if ( count($docinstitution) != 0) {
                $i = 0;
                $doc_institution = array();
                foreach ($docinstitution as $docinst){
                    $i++;
                    $ID_Institution = $docinst->ID_Institution;
                    $institution = Institution::find(" ID_Institution = '$ID_Institution'");
                    foreach ($institution as $inst){
                        $InstName = $inst->InstName;
                        $InstAdress = $inst->InstAdress;
                        $ID_Country = $inst->ID_Country;
                
                        $doc_institution[$i][0] = $ID_Institution;     
                        $doc_institution[$i][1] = $InstName; 
                        $doc_institution[$i][2] = $InstAdress; 
                        $doc_institution[$i][3] = $ID_Country; 
                        $doc_institution[$i][4] = 0;   
                    }
                }
            }
// die(var_dump($doc_institution));        
        $institutions = explode(";",$document->Institution);

        foreach ($institutions as $institution_name){
            
            $institution_name = trim($institution_name);
                $institutions_detail = explode(",",$institution_name);
                    
                $num_inst = count($institutions_detail);
//                echo $num_inst.'<BR>';
                    $InstName = trim($institutions_detail[0]);
                    if ( $num_inst == 1) {
                        $CountryName = '';
                        $ID_Country = 1;
                    }
                    if ( $num_inst == 2) $CountryName = trim($institutions_detail[1]);
            
            for ($j = 1; $j<=$i; $j++){
                if  ( strtolower($doc_institution[$j][1]) == strtolower($InstName) ) $doc_institution[$j][4] = 1;
            }
            
            $institution = Institution::find(" InstName = '$InstName' ");

            if (strlen($institution_name) > 0) {
                
                if ( count($institution) == 0) {
                    $institution = new Institution();
                    $institution->InstName =  $InstName;
                    $institution->InstAdress =  '-----';                                           

                    if ( $CountryName != '' ) {
                      $country = Country::find(" CountryName = '$CountryName'");    

                      if ( (count($country) == 0) ) {
                        $country = new Country();
                        $country->CountryName = $CountryName;
                        $country->CountryCode = '';
                        
                            if ($country->save() == false) {
                            foreach ($country->getMessages() as $message) {
                                 $this->flash->error($message);
                            }

                            return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "edit",
                                ]
                            );
                          } 
                          $country = Country::findFirst(" CountryName = '$CountryName'");    
                          $ID_Country = $country->ID_Country;
//                          $docinstitution->ID_Institution = $ID_Institution;
//die(var_dump($institution));                                              
                        }  else {
                            $country = Country::findFirst(" CountryName = '$CountryName'");    
                            $ID_Country = $country->ID_Country;     
//                            die(var_dump($country)); 
                        }                        
                    } else $ID_Country = 1;                    

                    $institution->ID_Country =  $ID_Country;
                    
                        if ($institution->save() == false) {
                            foreach ($institution->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                  }      
                }
                else {
// die(var_dump($institution));            
                }  
// die(var_dump($institution));            
                $institution = institution::findFirst("  InstName = '$InstName' ");                
                
                $ID_Institution = $institution->ID_Institution;
                $docinstitution = Docinstitution::find("(ID_Doc = '$ID_Doc' AND ID_Institution ='$ID_Institution')");
                if ( count($docinstitution) == 0) {
//                    echo $ID_Doc.' '.$ID_Institution.'<BR>';
                    $docinstitution = new Docinstitution();
                    $docinstitution->ID_Doc = $ID_Doc;
                    $docinstitution->ID_Institution = $ID_Institution;
                    
                    if ($docinstitution->save() == false) {
                        foreach ($docinstitution->getMessages() as $message) {
                             $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                        "controller" => "document",
                        "action"     => "edit",
                        ]
                    );
                  }   
                }
            }  
         }
// die(var_dump($institutiton));        
/**     **********************************************************
        *                                                        *  
        *  BRISANJE INSTITUTION AKO JE UKLONJEN IZ EDIT FORME         * 
        *                                                        *     
        ********************************************************** */ 
//        die(var_dump($doc_institution)); 
//         echo $i.'<BR>';
              for ($j = 1; $j<=$i; $j++){
                if  ( $doc_institution[$j][4] == 0){
                    $docinstitution = new Docinstitution();
                    $docinstitution->ID_Doc = $ID_Doc;
                    $docinstitution->ID_Institution = $doc_institution[$j][0];
//                            die(var_dump($docinstitution)); 
                if (!$docinstitution->delete()) {
                    foreach ($docinstitution->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "documentlink",
                            "action"     => "authorview",
                        ]
                    );
                }
            }
        }
       
        $docauthor = Docauthor::find("ID_Doc = '$ID_Doc'");

        $i = 0;
        if ( count($docauthor) != 0) {
            $i = 0;
            $doc_author = array();
            foreach ($docauthor as $docaut){
                $i++;
                $ID_Author = $docaut->ID_Author;
                $author = Author::find(" ID_Author = '$ID_Author'");
                foreach ($author as $aut){
                    $FirstName = $aut->FirstName;
                    $LastName = $aut->LastName;
                    $MiddleName = $aut->MiddleNameInitial;
                
                    $doc_author[$i][0] = $ID_Author;     
                    $doc_author[$i][1] = $LastName; 
                    $doc_author[$i][2] = $FirstName; 
                    $doc_author[$i][3] = $MiddleName; 
                    $doc_author[$i][4] = 0;   
                }
            }
        }
// die(var_dump($doc_author));        
        $authors = explode(";",$document->Author);
       
        foreach ($authors as $author_name_surname){
            
            $author_name_surname = trim($author_name_surname);
                $authors_detail = explode(",",$author_name_surname);
                $num_aut = count($authors_detail);
//                echo $num_aut.'<BR>';
                if ( $num_aut == 1) {
                    $LastName = trim($authors_detail[0]);
                    $FirstName = '';
                    $MiddleName = '';
                }
                if ( $num_aut == 2)  {
                    $LastName = trim($authors_detail[0]);
                    $FirstName = trim($authors_detail[1]);
                    $MiddleName = '';
                }
                if ( $num_aut == 3)  {
                    $LastName = trim($authors_detail[0]);
                    $FirstName = trim($authors_detail[1]);
                    $MiddleName = trim($authors_detail[2]);
                }
//            echo $LastName.' '.$FirstName.' '.$MiddleName.'<BR>';        
            
            for ($j = 1; $j<=$i; $j++){
                if  ( ($doc_author[$j][1] == $LastName) && ($doc_author[$j][2] == $FirstName)) $doc_author[$j][4] = 1;
//                echo $doc_author[$j][1].' '.$doc_author[$j][4].'<BR>';        
            }

            $author = Author::find(" ( LastName = '$LastName') AND ( FirstName = '$FirstName') ");
                    
            if (strlen($author_name_surname) > 0) {
                
                if ( count($author) == 0) {
                    $author = new Author();
                    $author->FirstName =  $FirstName;
                    $author->LastName =   $LastName;
                    $author->MiddleNameInitial =  $MiddleName;
                     
                    if ($author->save() == false) {
                        foreach ($author->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                  }      
                }
/**                else {
                    $authors_detail = explode(",",$author_name_surname);
                    $author_last_name = trim($authors_detail[0]);                    
                }  */
            
                $author = Author::findFirst(" ( LastName = '$LastName') AND ( FirstName = '$FirstName')");                
                
                $ID_Author = $author->ID_Author;
                $docauthor = Docauthor::find("(ID_Doc = '$ID_Doc' AND ID_Author ='$ID_Author')");
                if ( count($docauthor) == 0) {
//                    echo $ID_Doc.' '.$ID_Author.'<BR>';
                    $docauthor = new Docauthor();
                    $docauthor->ID_Doc = $ID_Doc;
                    $docauthor->ID_Author = $ID_Author;
                    $docauthor->ID_Institution = 1;
                    $docauthor->ID_Country = 1;
                    if ($docauthor->save() == false) {
                        foreach ($docauthor->getMessages() as $message) {
                             $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                        "controller" => "document",
                        "action"     => "edit",
                        ]
                    );
                  }   
                }
            }  
         }
        
/**     **********************************************************
        *                                                        *  
        *  BRISANJE AUTORA AKO JE UKLONJEN IZ EDIT FORME         * 
        *                                                        *     
        ********************************************************** */
              for ($j = 1; $j<=$i; $j++){
                if  ( $doc_author[$j][4] == 0){
                    $docauthor = new Docauthor();
                    $docauthor->ID_Doc = $ID_Doc;
                    $docauthor->ID_Author = $doc_author[$j][0];
        
                if (!$docauthor->delete()) {
                    foreach ($docauthor->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "documentlink",
                            "action"     => "authorview",
                        ]
                    );
                }
              }
            }
            
        $keywords = explode(";",$document->Keywords);
        
        foreach ($keywords as $keyword_name){
//            echo $keyword_name.'<BR>';
            $keyword_name = trim($keyword_name);
            
            $keyword = Keyword::find(" KeywordName = '$keyword_name'");
            if (strlen($keyword_name) > 0) {                    
                if ( count($keyword) == 0 ) {
                
                    $KeywordDescription = $keyword_name.'...';
                
                    $keyword = new keyword();
                    $keyword->KeywordName = $keyword_name;
                    $keyword->KeywordDescription = $KeywordDescription;
                                
                    if ($keyword->save() == false) {
                        foreach ($keyword->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                }
              }
//            }
            
              $keyword = Keyword::find(" KeywordName = '$keyword_name'");                
           
              foreach ( $keyword as $keyword_id )  {
                    
                  $ID_Keyword = $keyword_id->ID_Keyword;
              }
                
	        $dockeyword = Dockeyword::find("(ID_Keyword = '$ID_Keyword' AND ID_Doc ='$ID_Doc')");
//                        die(var_dump($dockeyword));                        
                    if ( count($dockeyword) == 0) {
                        
                            $dockeyword = new Dockeyword();
                            $dockeyword->ID_Keyword = $ID_Keyword;
                            $dockeyword->ID_Doc = $ID_Doc;                      
                            if ($dockeyword->save() == false) {
                                foreach ($dockeyword->getMessages() as $message) {
                                $this->flash->error($message);
                            }

                            return $this->dispatcher->forward(
                            [
                                "controller" => "document",
                                "action"     => "new",
                            ]
                        );
                    }   
              }

              $documentculturaldomain = Documentculturaldomain::find(" ID_Doc = '$ID_Doc'");
              
                foreach ($documentculturaldomain as $docculturaldomain){

                    $ID_CultDomain = $docculturaldomain->ID_CultDomain;
                    $keywordculturaldomain = Keywordculturaldomain::find("(ID_Keyword = '$ID_Keyword' AND ID_CultDomain ='$ID_CultDomain')");
                    if ( count($keywordculturaldomain) == 0) {
                        $keywordculturaldomain = new Keywordculturaldomain();
                        $keywordculturaldomain->ID_Keyword = $ID_Keyword;
                        $keywordculturaldomain->ID_CultDomain = $ID_CultDomain;                      
                        if ($keywordculturaldomain->save() == false) {
                          foreach ($keywordculturaldomain->getMessages() as $message) {
                             $this->flash->error($message);
                          }

                            return $this->dispatcher->forward(
                            [
                                "controller" => "document",
                                "action"     => "edit",
                            ]
                        );
                      }   
                   }
                }    
                
                $documentsocialimpact = Documentsocialimpact::find(" ID_Doc = '$ID_Doc'");

                foreach ($documentsocialimpact as $docsocialimpact){

                    $ID_SocImpact = $docsocialimpact->ID_SocImpact;
//                    echo $ID_SocImpact;
                    $keywordsocialimpact = Keywordsocialimpact::find("(ID_Keyword = '$ID_Keyword' AND ID_SocImpact ='$ID_SocImpact')");
                    if ( count($keywordsocialimpact) == 0) {
                        $keywordsocialimpact = new Keywordsocialimpact();
                        $keywordsocialimpact->ID_Keyword = $ID_Keyword;
                        $keywordsocialimpact->ID_SocImpact = $ID_SocImpact;                      
                        if ($keywordsocialimpact->save() == false) {
                          foreach ($keywordsocialimpact->getMessages() as $message) {
                             $this->flash->error($message);
                          }

                            return $this->dispatcher->forward(
                            [
                                "controller" => "document",
                                "action"     => "edit",
                            ]
                        );
                      }   
                   }
                } 
            }    
        }    
          
        $doctechnique = Doctechnique::find("ID_Doc = '$ID_Doc'");
// die(var_dump($doctechnique));        
        $i = 0;
        if ( count($doctechnique) != 0) {
            $i = 0;
            $doc_technique = array();
            foreach ($doctechnique as $docteh){
                $i++;
                $ID_Technique = $docteh->ID_Technique;
                $technique = Technique::find(" ID_Technique = '$ID_Technique'");

                foreach ($technique as $teh){
                 
                    $TechniqueName = trim($teh->TechniqueName);
                    $doc_technique[$i][0] = $ID_Technique;     
                    $doc_technique[$i][1] = $TechniqueName; 
                    $doc_technique[$i][2] = 0;   
                }
            }
        }

        $technique = explode(";",$document->Technique);
    
        foreach ($technique as $technique_name){
            
            $technique_name = trim($technique_name);
            
            for ($j = 1; $j<=$i; $j++){
                if  ( ($doc_technique[$j][1] == $technique_name)) $doc_technique[$j][2] = 1;
            }

            $technique = Technique::find(" TechniqueName = '$technique_name'");
//       echo $technique_name.'-<BR>';        
            if (strlen($technique_name) > 0) {
                
                if ( count($technique) == 0) {
                    
                    $technique = new Technique();
                    $technique->TechniqueName =  $technique_name;
                     
                    if ($technique->save() == false) {
                        foreach ($technique->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                  }      
                }
            
                $technique = Technique::findFirst(" TechniqueName = '$technique_name'");                
 
                $ID_Technique = $technique->ID_Technique;
                $doctechnique = Doctechnique::find("(ID_Doc = '$ID_Doc' AND ID_Technique ='$ID_Technique')");
                if ( count($doctechnique) == 0) {
//                    echo $ID_Doc.' '.$ID_Author.'<BR>';
                    $doctechnique = new Doctechnique();
                    $doctechnique->ID_Doc = $ID_Doc;
                    $doctechnique->ID_Technique = $ID_Technique;
                    if ($doctechnique->save() == false) {
                        foreach ($doctechnique->getMessages() as $message) {
                             $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                        "controller" => "document",
                        "action"     => "edit",
                        ]
                    );
                  }   
                }
            }  
         }
        
/**     **********************************************************
        *                                                        *  
        *  BRISANJE TECHNIQUE AKO JE UKLONJEN IZ EDIT FORME         * 
        *                                                        *     
        ********************************************************** */
              for ($j = 1; $j<=$i; $j++){
                if  ( $doc_technique[$j][2] == 0){
                    $doctechnique = new Doctechnique();
                    $doctechnique->ID_Doc = $ID_Doc;
                    $doctechnique->ID_Technique = $doc_technique[$j][0];
        
                if (!$doctechnique->delete()) {
                    foreach ($doctechnique->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                }
              }
            }
        
            
        $keywordtv = explode(";",$document->keywordtv);

        foreach ($keywordtv as $keywordtv_name){
            
            $keywordtv_name = trim($keywordtv_name);
            
/**            for ($j = 1; $j<=$i; $j++){
                if  ( ($doc_technique[$j][1] == $technique_name)) $doc_technique[$j][2] = 1;
            }  */

            $keywordtv = Keywordtv::find(" KeywordtvName = '$keywordtv_name'");
            
            if (strlen($keywordtv_name) > 0) {
                
                if ( count($keywordtv) == 0) {
                    
                    $keywordtv = new Keywordtv();
                    $keywordtv->KeywordtvName =  $keywordtv_name;
                     
                    if ($keywordtv->save() == false) {
                        foreach ($keywordtv->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                  }      
                }
            
/**                $keywordtv = Keywordtv::findFirst(" KeywordtvName = '$keywordtv_name'");                
 
                $ID_Keywordtv = $keywordtv->ID_Keywordtv;
                $dockeywordtv = Dockeywordtv::find("(ID_Doc = '$ID_Doc' AND ID_Keywordtv ='$ID_Keywordtv')");
                if ( count($dockeywordtv) == 0) {
//                    echo $ID_Doc.' '.$ID_Author.'<BR>';
                    $dockeywordtv = new Dockeywordtv();
                    $dockeywordtv->ID_Doc = $ID_Doc;
                    $dockeywordtv->ID_Keywordtv = $ID_Keywordtv;
                    if ($dockeywordtv->save() == false) {
                        foreach ($dockeywordtv->getMessages() as $message) {
                             $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                        "controller" => "document",
                        "action"     => "edit",
                        ]
                    );
                  }   
                } */
            }  
         }
        
/**     **********************************************************
        *                                                        *  
        *  BRISANJE KEYWORD TRANS. VAR. AKO JE UKLONJEN IZ EDIT FORME         * 
        *                                                        *     
        ********************************************************** */
/**              for ($j = 1; $j<=$i; $j++){
                if  ( $doc_technique[$j][2] == 0){
                    $doctechnique = new Doctechnique();
                    $doctechnique->ID_Doc = $ID_Doc;
                    $doctechnique->ID_Technique = $doc_technique[$j][0];
        
                if (!$doctechnique->delete()) {
                    foreach ($doctechnique->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                }  
              }  
            }    */
         
        $transitionvar = explode(";",$document->transitionvar);

        foreach ($transitionvar as $transitionvar_name){
            
            $transitionvar_name = trim($transitionvar_name);
            
/**            for ($j = 1; $j<=$i; $j++){
                if  ( ($doc_technique[$j][1] == $technique_name)) $doc_technique[$j][2] = 1;
            }  */

            $transitionvar = Transitionvar::find(" TransvarName = '$transitionvar_name'");

            if (strlen($transitionvar_name) > 0) {
                
                if ( count($transitionvar) == 0) {
                    
                    $transitionvar = new Transitionvar();
                    $transitionvar->TransvarName =  $transitionvar_name;
                     
                    if ($transitionvar->save() == false) {
                        foreach ($transitionvar->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                  }      
                }
            
/**                $keywordtv = Keywordtv::findFirst(" KeywordtvName = '$keywordtv_name'");                
 
                $ID_Keywordtv = $keywordtv->ID_Keywordtv;
                $dockeywordtv = Dockeywordtv::find("(ID_Doc = '$ID_Doc' AND ID_Keywordtv ='$ID_Keywordtv')");
                if ( count($dockeywordtv) == 0) {
//                    echo $ID_Doc.' '.$ID_Author.'<BR>';
                    $dockeywordtv = new Dockeywordtv();
                    $dockeywordtv->ID_Doc = $ID_Doc;
                    $dockeywordtv->ID_Keywordtv = $ID_Keywordtv;
                    if ($dockeywordtv->save() == false) {
                        foreach ($dockeywordtv->getMessages() as $message) {
                             $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                        "controller" => "document",
                        "action"     => "edit",
                        ]
                    );
                  }   
                } */
            }  
         }
        
/**     **********************************************************
        *                                                        *  
        *  BRISANJE KEYWORD TRANS. VAR. AKO JE UKLONJEN IZ EDIT FORME         * 
        *                                                        *     
        ********************************************************** */
/**              for ($j = 1; $j<=$i; $j++){
                if  ( $doc_technique[$j][2] == 0){
                    $doctechnique = new Doctechnique();
                    $doctechnique->ID_Doc = $ID_Doc;
                    $doctechnique->ID_Technique = $doc_technique[$j][0];
        
                if (!$doctechnique->delete()) {
                    foreach ($doctechnique->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                }  
              }  
            }    */
            
        $docdataprov = Docdataprov::find("ID_Doc = '$ID_Doc'");
 
        $i = 0;
        if ( count($docdataprov) != 0) {
            $i = 0;
            $doc_dataprov = array();
            foreach ($docdataprov as $docprov){
                $i++;
                $ID_DataProv = $docprov->ID_DataProv;
                $dataprov = Dataprov::find(" ID_DataProv = '$ID_DataProv'");

                foreach ($dataprov as $prov){
                 
                    $DataProvName = trim($prov->DataProvName);
                    $doc_dataprov[$i][0] = $ID_DataProv;     
                    $doc_dataprov[$i][1] = $DataProvName; 
                    $doc_dataprov[$i][2] = 0;   
                }
            }
        }

        $dataprov = explode(";",$document->DataProviders);

        foreach ($dataprov as $dataprov_name){
            
            $dataprov_name = trim($dataprov_name);
            
            for ($j = 1; $j<=$i; $j++){
                if  ( ($doc_dataprov[$j][1] == $dataprov_name)) $doc_dataprov[$j][2] = 1;
            }

            $dataprov = Dataprov::find(" DataProvName = '$dataprov_name'");

            if (strlen($dataprov_name) > 0) {

                if ( count($dataprov) == 0) {

                    $dataprov = new Dataprov();
                    $dataprov->DataProvName =  $dataprov_name;
                     
                    if ($dataprov->save() == false) {
                        foreach ($dataprov->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                  }      
                }
                
                $dataprov = Dataprov::findFirst(" DataProvName = '$dataprov_name'");   
                $ID_DataProv = $dataprov->ID_DataProv;
                
                $docdataprov = Docdataprov::find("(ID_Doc = '$ID_Doc' AND ID_DataProv ='$ID_DataProv')");

                if ( count($docdataprov) == 0) {

                    $docdataprov = new Docdataprov();
                    $docdataprov->ID_Doc = $ID_Doc;
                    $docdataprov->ID_DataProv = $ID_DataProv;

                    if ($docdataprov->save() == false) {
                        foreach ($dataprov->getMessages() as $message) {
                             $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                        "controller" => "document",
                        "action"     => "edit",
                        ]
                    );
                  }   
                }
            }  
         }
        
/**     **********************************************************
        *                                                        *  
        *  BRISANJE DATA PROVIDER AKO JE UKLONJEN IZ EDIT FORME         * 
        *                                                        *     
        ********************************************************** */
              for ($j = 1; $j<=$i; $j++){
                if  ( $doc_dataprov[$j][2] == 0){
                    $docdataprov = new Docdataprov();
                    $docdataprov->ID_Doc = $ID_Doc;
                    $docdataprov->ID_DataProv = $doc_dataprov[$j][0];
        
                if (!$docdataprov->delete()) {
                    foreach ($docdataprov->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                }
              }
            }
            
        $docsearchdatabase = Docsearchdatabase::find("ID_Doc = '$ID_Doc'");
 
        $i = 0;
        if ( count($docsearchdatabase) != 0) {
            $i = 0;
            $doc_searchdatabase = array();
            foreach ($docsearchdatabase as $docsearch){
                $i++;
                $ID_Database = $docsearch->ID_Database;
                $databasesearch = Searchdatabase::find(" ID_Database = '$ID_Database'");

                foreach ($databasesearch as $search){
                 
                    $DatabaseName = trim($search->SearchDatabase);
                    $doc_searchdatabase[$i][0] = $ID_Database;     
                    $doc_searchdatabase[$i][1] = $DatabaseName; 
                    $doc_searchdatabase[$i][2] = 0;   
                }
            }
        }

        $searchdatabase = explode(";",$document->Searchdatabase);

        foreach ($searchdatabase as $searchdatabase_name){
      
            $searchdatabase_name = trim($searchdatabase_name);
                
//                echo $searchdatabase_name.'<BR>';        
            
            for ($j = 1; $j<=$i; $j++){
                if  ( ($doc_searchdatabase[$j][1] == $searchdatabase_name)) $doc_searchdatabase[$j][2] = 1;
            }
 
            $searchdatabase = Searchdatabase::find(" SearchDatabase = '$searchdatabase_name'");

            if (strlen($searchdatabase_name) > 0) {
      
                if ( count($searchdatabase) == 0) {
               
//                    echo 'Evo <BR>';
                    $searchdatabase = new Searchdatabase();
                    $searchdatabase->SearchDatabase =  $searchdatabase_name;

                    if ($searchdatabase->save() == false) {
                        foreach ($searchdatabase->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                  }      
                }
            
                $searchdatabase = Searchdatabase::findFirst(" SearchDatabase = '$searchdatabase_name'");                
 
                $ID_Database = $searchdatabase->ID_Database;
                $docsearchdatabase = Docsearchdatabase::find("(ID_Doc = '$ID_Doc' AND ID_Database ='$ID_Database')");
  
                if ( count($docsearchdatabase) == 0) {
//                    echo $ID_Doc.' '.$ID_Database.'<BR>';
                    $docsearchdatabase = new Docsearchdatabase();
                    $docsearchdatabase->ID_Doc = $ID_Doc;
                    $docsearchdatabase->ID_Database = $ID_Database;
  
                    if ($docsearchdatabase->save() == false) {
                        foreach ($docsearchdatabase->getMessages() as $message) {
                             $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                        "controller" => "document",
                        "action"     => "edit",
                        ]
                    );
                  }   
                }
            }  
         } 
        
/**     **********************************************************
        *                                                        *  
        *  BRISANJE SEARCH DATABASE AKO JE UKLONJEN IZ EDIT FORME         * 
        *                                                        *     
        ********************************************************** */
             for ($j = 1; $j<=$i; $j++){
                if  ( $doc_searchdatabase[$j][2] == 0){
                    $docsearchdatabase = new Docsearchdatabase();
                    $docsearchdatabase->ID_Doc = $ID_Doc;
                    $docsearchdatabase->ID_Database = $doc_searchdatabase[$j][0];
        
                if (!$docsearchdatabase->delete()) {
                    foreach ($docsearchdatabase->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                }
              }
            } 
    
        $doccity = Doccity::find("ID_Doc = '$ID_Doc'");
 
        $i = 0;
        if ( count($doccity) != 0) {
            $i = 0;
            $doc_city = array();
            foreach ($doccity as $doc_city_data){
                $i++;
                $ID_City = $doc_city_data->ID_City;
                $city = City::find(" ID_City = '$ID_City'");
                foreach ($city as $city_data){
                    $CityName = $city_data->CityName;
                    $CityCode = $city_data->CityCode;                    
                
                    $doc_city[$i][0] = $ID_City;     
                    $doc_city[$i][1] = $CityName; 
                    $doc_city[$i][2] = $CityCode;   
                    $doc_city[$i][3] = 0;   
                }
            }
        }
// die(var_dump($doc_city));        
        $city = explode(";",$document->city);
// die(var_dump($city));        
        foreach ($city as $city_name){
            
            $city_name = trim($city_name);
                            
            for ($j = 1; $j<=$i; $j++){
                if  ( $doc_city[$j][1] == $city_name ) $doc_city[$j][3] = 1;
            }

            $city = City::find(" CityName = '$city_name' ");
                    
            if (strlen($city_name) > 0) {
                
                if ( count($city) == 0) {
                    $city = new City();
                    $city->CityName =  $city_name;
                    $city->ID_Country = 1;
                     
                    if ($city->save() == false) {
                        foreach ($city->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "edit",
                        ]
                    );
                  }      
                }
                   
            
                $city = City::findFirst(" CityName = '$city_name'");                
                
                $ID_City = $city->ID_City;
                $doccity = Doccity::find("(ID_Doc = '$ID_Doc' AND ID_City ='$ID_City')");
                if ( count($doccity) == 0) {
//                    echo $ID_Doc.' '.$ID_Author.'<BR>';
                    $doccity = new Doccity();
                    $doccity->ID_Doc = $ID_Doc;
                    $doccity->ID_City = $ID_City;
                    if ($doccity->save() == false) {
                        foreach ($doccity->getMessages() as $message) {
                             $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                        [
                        "controller" => "document",
                        "action"     => "edit",
                        ]
                    );
                  }   
                }
            }  
         } 
        
/**     **********************************************************
        *                                                        *  
        *  BRISANJE CITY AKO JE UKLONJEN IZ EDIT FORME         * 
        *                                                        *     
        **********************************************************  */
            for ($j = 1; $j<=$i; $j++){
                if  ( $doc_city[$j][3] == 0 ){
                    $doccity = new Doccity();
                    $doccity->ID_Doc = $ID_Doc;
                    $doccity->ID_City = $doc_city[$j][0];
        
                if (!$doccity->delete()) {
                    foreach ($doccity->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "documentlink",
                            "action"     => "cityview",
                        ]
                    );
                }
              }
            }  
            
        return $this->dispatcher->forward(
            [
                "controller" => "document",
                "action"     => "view",
            ]
        );  
        
      } 

         
    
    public function deleteAction($ID_Doc)
    {
         
       $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        
       $this->view->form = new DocumentForm($document, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Doc = $this->request->getPost("ID_Doc", "string");
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        if (!$document) {
            $this->flash->error("Document not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "index",
                ]
            );
        }  

 $docsector = Docsector::Find("ID_Doc = '$ID_Doc'");

        foreach ($docsector as $sector) {
            if (!$docsector->delete()) {
                foreach ($document->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                 );
               }         
            }

        $docauthor = Docauthor::Find("ID_Doc = '$ID_Doc'");

        foreach ($docauthor as $author) {
            if (!$docauthor->delete()) {
                foreach ($document->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                 );
               }         
            }
            
        $doccountry = Doccountry::Find("ID_Doc = '$ID_Doc'");

        foreach ($doccountry as $country) {
            if (!$doccountry->delete()) {
                foreach ($document->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                 );
               }         
            }    

        $docinstitution = Docinstitution::Find("ID_Doc = '$ID_Doc'");

        foreach ($docinstitution as $institution) {
            if (!$docinstitution->delete()) {
                foreach ($docinstitution->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                 );
               }         
            }    
            
        $docsearchdatabase = Docsearchdatabase::Find("ID_Doc = '$ID_Doc'");

        foreach ($docsearchdatabase as $searchdatabase) {
            if (!$docsearchdatabase->delete()) {
                foreach ($docsearchdatabase->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                 );
               }         
            }        
        
        $docdataprov = Docdataprov::Find("ID_Doc = '$ID_Doc'");

        foreach ($docdataprov as $dataprov) {
            if (!$docdataprov->delete()) {
                foreach ($docdataprov->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                 );
               }         
            }      
            
        $doctechnique = Doctechnique::Find("ID_Doc = '$ID_Doc'");

        foreach ($doctechnique as $technique) {
            if (!$doctechnique->delete()) {
                foreach ($doctechnique->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                 );
               }         
            }         
 
        $docculturaldomain = Documentculturaldomain::Find("ID_Doc = '$ID_Doc'");

        foreach ($docculturaldomain as $culturaldomain) {
            if (!$docculturaldomain->delete()) {
                foreach ($docculturaldomain->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                 );
               }         
            }        
            
        $docsocialimpact = Documentsocialimpact::Find("ID_Doc = '$ID_Doc'");

        foreach ($docsocialimpact as $socialimpact) {
            if (!$docsocialimpact->delete()) {
                foreach ($docsocialimpact->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                 );
               }         
            }        
            
        $docupload = Upload::Find("ID_Doc = '$ID_Doc'");

        foreach ($docupload as $docupload) {
            if (!$docupload->delete()) {
                foreach ($docupload->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                 );
               }         
            }            

        $doccity = Doccity::Find("ID_Doc = '$ID_Doc'");

        foreach ($doccity as $city) {
            if (!$doccity->delete()) {
                foreach ($doccity->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                 );
               }         
            }                     
            

        $doccity = Doccity::Find("ID_Doc = '$ID_Doc'");

        foreach ($doccity as $city) {
            if (!$doccity->delete()) {
                foreach ($doccity->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                 );
               }         
            }                     
            
        $dockeyword = Dockeyword::Find("ID_Doc = '$ID_Doc'");

        foreach ($dockeyword as $keyword) {
            if (!$dockeyword->delete()) {
                foreach ($dockeyword->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                 );
               }         
            }       


        $doctranvatkeywordtv = Transitionvarkeywordtv::Find("ID_Doc = '$ID_Doc'");
       
            if (!$doctranvatkeywordtv->delete()) {
            foreach ($doctranvatkeywordtv->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "index",
                ]
            );
        }

	 $doctransitionvar = Doctransitionvar::Find("ID_Doc = '$ID_Doc'");
       
            if (!$doctransitionvar->delete()) {
            foreach ($doctransitionvar->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "index",
                ]
            );
        }

        $documentextented = Documentextented::Find("ID_Doc = '$ID_Doc'");

            if (!$documentextented->delete()) {
            foreach ($documentextented->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "index",
                ]
            );
        }
       
        if (!$document->delete()) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Document deleted");  

                
        return $this->dispatcher->forward(
            [
                "controller" => "document",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new DocumentForm;
        $this->view->form = new AuthorForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "document",
                "action"     => "index",
            ]  
        );  
    }
    
       public function linksauthorAction($ID_Doc){
        
        $numberPage = 1;
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docauthor = Docauthor::find("ID_Doc = '$ID_Doc'");
        if (count($docauthor) == 0) {
            $this->flash->notice("Document not found.");
        }    
     
        $paginator = new Paginator(array(
            "data"  => $docauthor,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
           
        $this->view->form = new AuthorForm;
        
//        $queryauthor = $this->modelsManager->createQuery("SELECT * FROM Author");
//        $author  = $queryauthor->execute();   
        
    }
    
      public function linkscountryAction($ID_Doc){
        
        $numberPage = 1;
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $doccountry = Doccountry::find("ID_Doc = '$ID_Doc'");
        if (count($doccountry) == 0) {
            $this->flash->notice("Author not found.");
        }    
     
        $paginator = new Paginator(array(
            "data"  => $doccountry,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
  
    }

    public function createdocumenttemplateAction(){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Template")) {
            // Retrieve its value
            $ID_Template = $this->session->get("ID_Template");
        }
                
        $template = Template::findFirst(" ID_Template = '$ID_Template'");
      
//        die(var_dump($template));  
        $document = new Document();
        
        $document = Document::find(" ID_Template = '$ID_Template'");
//        die(var_dump($document));
//        echo 'Hey - '.$document->ID_Template;
//        echo count($document);
        if (count($document) > 0) {          
                $document = Document::findFirst(" ID_Template = '$ID_Template'");
                $ID_Doc = $document->ID_Doc;            
//                echo $ID_Doc.'<BR>';
            } else {
    
                $document = new Document();
        
                $document->Title = $template->Title;
                $document->PubYear = $template->PubYear;
                $document->Summary = $template->Summary;
                $document->OpenAccess = $template->OpenAccess;
                $document->OpenAccess = $template->OpenAccess;
                $document->CountryPub = $template->CountryPub;
                $document->ID_Language = $template->ID_Language;
                $document->Keywords  = $template->Keywords;
                $document->Links  = $template->Links;
                $document->ID_Type  = 2;
                $document->NumPages  = 0;
                $document->ID_Template  = $template->ID_Template;
//                die(var_dump($document));
            
                if ($document->save() == false) {
                    foreach ($document->getMessages() as $message) {
                        $this->flash->error($message);
                        }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "new",
                        ]
                     );
                } 
            }   
      
               
//        die(var_dump($document));
        $document = Document::findFirst(" ID_Template = '$ID_Template'");
        $ID_Doc = $document->ID_Doc;
                
        $templatesocimpact = Templatesocialimpact::find(" ID_Template = '$ID_Template'");  
             
            foreach ($templatesocimpact as $socimpact) {
                $documentsocimpact = new Documentsocialimpact();
                $documentsocimpact->ID_Doc = $ID_Doc;
                $documentsocimpact->ID_SocImpact = $socimpact->ID_SocImpact;
                if ($documentsocimpact->save() == false) {
                       foreach ($documentsocimpact->getMessages() as $message) {
                    $this->flash->error($message);
                  }
                }  
            }
       
             $templatecultdomain = Templateculturaldomain::find(" ID_Template = '$ID_Template'");  
             
            foreach ($templatecultdomain as $cultdomain) {
                $documentculturaldomain = new Documentculturaldomain();
                $documentculturaldomain->ID_Doc = $ID_Doc;
                $documentculturaldomain->ID_CultDomain = $cultdomain->ID_CultDomain;
                if ($documentculturaldomain->save() == false) {
                       foreach ($documentculturaldomain->getMessages() as $message) {
                    $this->flash->error($message);
                  }
                }  
            }
        
        $document = Document::findFirst(" ID_Template = '$ID_Template'");    
        
//        $this->view->form = new DocumentFullForm($document, array('edit' => true));
         
        return $this->dispatcher->forward(
            [
                "controller" => "document",
                "action"     => "pregled",
                "params"     => [$ID_Doc]
            ]  
        );  
            
    }
    
     public function exportAction(){
        
        $numberPage = 1;
        
        $document = Document::find();
        
        $export = '';
        $path = "export_ver2.txt";
	$fp = fopen($path, 'a');
        
        foreach ( $document as $document_data) {
            
            $ID = $document_data->ID_Doc;
            $Title = $document_data->Title;          
            $Keyword = $document_data->Keywords;          
            $Link = $document_data->Links;
            $Summary = $document_data->Summary;
            $Findings = $document_data->FindingsOutcomes;          
            $Keywordtv = $document_data->keywordtv;
            $Transitionvar = $document_data->transitionvar;      
            $Searchdatabase = $document_data->Searchdatabase;      
            
            $export_array = array();
            $export_array ["ID"] = $document_data->ID_Doc;
            $export_array ["Title"] = $document_data->Title;          
            $export_array ["Keyword"] = $document_data->Keywords;          
            $export_array ["Link"] = $document_data->Links;
            $export_array ["Summary"] = $document_data->Summary;
            $export_array ["Findings"] = $document_data->FindingsOutcomes;          
            $export_array ["Keywordtv"] = $document_data->keywordtv;
            $export_array ["Transitionvar"] = $document_data->transitionvar;                  
           
            $cultdomain ='';
            $socimpact ='';
            $doccultdomain = "SELECT CD.CultDomainName FROM documentculturaldomain DC INNER JOIN culturaldomain CD ON CD.ID_CultDomain = DC.ID_CultDomain WHERE DC.ID_Doc = $ID";        
                $resultGeneral = $this->db->query($doccultdomain);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $cultdomain .= $result['CultDomainName'].';';
                 }
            $cultdomain = rtrim($cultdomain,";");
            $export_array ["Cultdomain"] = $cultdomain;
            
            $docsocimpact = "SELECT SC.SocImpactName FROM documentsocialimpact DS INNER JOIN socialimpact SC ON SC.ID_SocImpact = DS.ID_SocImpact WHERE DS.ID_Doc = $ID";        
                $resultGeneral = $this->db->query($docsocimpact);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $socimpact .= $result['SocImpactName'].';';
                 }
                 
            $socimpact = rtrim($socimpact,";");
            $export_array ["Socimpact"] = $socimpact;
            
            $export_array ["Searchdatabase"] = $document_data->Searchdatabase;      
            $export_array ["Authors"] = $document_data->Author;                  
            
            $export .= $ID.'-'.$Title.'-'.$Keyword.'-'.$Link.'-'.$Summary.'-'.$Findings.'-'.$Keywordtv.'-'.$Transitionvar.'-'.$cultdomain.'-'.$socimpact.'.\n';
            
//            $format = "%s=%s=%s=%s=%s=%s=%s=%s=%s=%s=%s\n";
//            $buf = sprintf($format, "$ID", "$Title", "$Keyword", "$Link", "$Summary", "$Findings", "$Keywordtv", "$Transitionvar", "$cultdomain", "$socimpact", "$Searchdatabase");
              
            foreach($export_array as $export_type => $export_name)
                {
                if ( $export_array ["ID"] < 111){
                    if ( ($export_type == "ID") || ($export_type  == "Authors") ) {
                        echo 'Hey';
                    $format = "%s|%s\n";
                      $buf = sprintf($format, "$export_type","$export_name");
//                    $buf = sprintf("Part name is: <strong>%s</strong> Part value is: <strong>%s</strong>",$part_type,"$part_name"); 
                    fwrite($fp, $buf, strlen($buf));                    
                   }
                 } else {
                  $format = "%s|%s\n";
                    $buf = sprintf($format, "$export_type","$export_name");
//                    $buf = sprintf("Part name is: <strong>%s</strong> Part value is: <strong>%s</strong>",$part_type,"$part_name"); 
                    fwrite($fp, $buf, strlen($buf));
                 }   
                }  
   
/**              $format = "=>%s\n";
              $buf = sprintf($format, "Novi dokument");
              fwrite($fp, $buf, strlen($buf));
              $buf = sprintf($format, "$ID");
              fwrite($fp, $buf, strlen($buf));
              $buf = sprintf($format, "$Title");
              fwrite($fp, $buf, strlen($buf));
              $buf = sprintf($format, "$Keyword");
              fwrite($fp, $buf, strlen($buf));
              $buf = sprintf($format, "$Link");
              fwrite($fp, $buf, strlen($buf));
              $buf = sprintf($format, "$Summary");
              fwrite($fp, $buf, strlen($buf));
              $buf = sprintf($format, "$Findings");
              fwrite($fp, $buf, strlen($buf));
              $buf = sprintf($format, "$Keywordtv");
              fwrite($fp, $buf, strlen($buf));
              $buf = sprintf($format, "$Transitionvar"); 
              fwrite($fp, $buf, strlen($buf));
              $buf = sprintf($format, "$cultdomain");
              fwrite($fp, $buf, strlen($buf));
              $buf = sprintf($format, "$socimpact");
              fwrite($fp, $buf, strlen($buf));
              $buf = sprintf($format, "$Searchdatabase"); 
              fwrite($fp, $buf, strlen($buf)); */

//	    fwrite($fp, $buf, strlen($buf));
        }         
           
           echo $export.'<BR>';
           echo '<BR>';
           
           
//
     }       
        
    public function uploadfile1Action()
    {
/**        // Check if the user has uploaded files
        $ispis ='Hey!';
        die(var_dump($ispis));
        if ($this->request->hasFiles() == true) {
            // Print the real file names and sizes
            foreach ($this->request->getUploadedFiles() as $file) {

                //Print file details
                echo $file->getName(), " ", $file->getSize(), "\n";

                //Move the file into the application
                $file->moveTo('files/'); */
          if ($this->request->hasFiles() == true) {           
               $fi = new finfo(FILEINFO_MIME, '/usr/share/misc/file/magic');
                foreach ($this->request->getUploadedFiles() as $file) {
                echo 'Mime = ', $fi->file($file->getTempName()), '<br>';                 
               }
            }
    }
    
    public function uploadfileAction()
    {
echo 'Hey';


/** namespace App\Backoffice\Controllers;
use App\Core\Forms\MediaForm;
class MediaController extends BaseController {
public function addAction() {
$this->view->form = new MediaForm();
}
public function uploadAction() {
if (true == $this->request->hasFiles() &&                
$this->request->isPost()) {
    $upload_dir = __DIR__ . '/../../../public/uploads/';
if (!is_dir($upload_dir)) {
mkdir($upload_dir, 0755);
}
foreach ($this->request->getUploadedFiles() as $file) {
$file->moveTo($upload_dir . $file->getName());
$this->flashSession->success($file->getName().' has been
successfully uploaded.');
}
$this->response->redirect('media/add');
}
}


        if(isset($_FILES['image'])){
        $errors= array();
        $file_name = $_FILES['image']['name'];
        $file_size =$_FILES['image']['size'];
        $file_tmp =$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
        $extensions= array("jpeg","jpg","png");
      
        if(in_array($file_ext,$extensions)=== false){
          $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
      
         if($file_size > 2097152){
             $errors[]='File size must be excately 2 MB';
        }
      
        if(empty($errors)==true){
             move_uploaded_file($file_tmp,"images/".$file_name);
            echo "Success";
        }else{
             print_r($errors);
          } 
      }  */
        
    }
/**        }
    } */

    public function prepareAction(){
        
        $numberPage = 1;
        
        $document = Document::find();
     
        if (true == $this->request->hasFiles() && $this->request->isPost()) 
          {
        
            $upload_dir = __DIR__ . '/../../public/prepare/';
            echo $upload_dir.'<BR>';
            foreach ($this->request->getUploadedFiles() as $file) {
                $file->moveTo($upload_dir . $file->getName());
                $this->flashSession->success($file->getName().' has been successfully uploaded.');
                $filename = $file->getName();
            }

        } 
        
        $export = '';
         $path = $upload_dir . $file->getName();
         echo $path;
//        $path = "2.csv";
//        echo($file->getName());
//        $path = $filename; 
	
//        $path = "/uploads/1.csv";
        $fp = fopen($path, "r");

	$buf = "";
	/* Make sure the file was succesfully opened */
	if(!$fp)
	{
		$fp = fopen($path, 'c');
	}
	else	
	{
		/* Loop over the file storing the file into a buffer */
		while(!feof($fp))
			$buf .= fread($fp, 4096);
	}
	fclose($fp);
        
        $trans_temp = explode("\n", $buf);	
	/* Unset buffer since we have the data in an array now */
	unset($buf);
  
        $document = new Document();
        
        foreach($trans_temp as $trans)
	{
	    $tran = explode(";", $trans); // Data is tab delimited                           

            if (strlen($tran[0]) > 0 ) $key = $tran[0];
            if (strlen($tran[1]) > 0 )$value = $tran[1];
            
            switch ($key) {
                case "Year of publication": 
                    $document->PubYear = $value;
                    break;
                case "Title": 
                    $document->Title = $value;
                    break;
                case "Bibliografic reference": 
                    $document->BiblioRef = $value;
                    break;
                case "Document Type": 
                    $document->ID_Type = $value;
                    break;
                case "Language": 
                    $document->ID_Language = $value;
                    break;
                case "Number of pages": 
                    $document->NumPages = $value;
                    break;
                case "Link to document": 
                    $document->Links = $value;
                    break;
                case "Abstract": 
                    $document->Summary = $value;
                    break;
                case "Time period of data": 
                    $document->PeriodFrom = $value;
                    break;
                case "Metholodogy": 
                    $document->Methodology = $value;
                    break;
                 case "Techniques": 
                    $document->Technique = $value;
                    break;
                case "Data providers": 
                    $document->DataProviders = $value;
                    break;               
                case "Findings and outcomes": 
                    $document->FindingOutcomes = $value;
                    break;
                case "Keywords": 
                    $document->Keywords = $value;
                    break;
                case "Relevance": 
                    $document->Relevance = $value;
                    break;
                case "Search Database": 
                    $document->Searchdatabase = $value;
                    break;
                case "Open access": 
                    $document->OpenAccess = $value;
                    break;
                case "Institution": 
                    $document->Institution = $value;
                    break;
                case "Authors": 
                    $document->Author = $value;
                    break;

            }
                    
	 }

    $this->view->form = new DocumentFullForm($document, array('edit' => true));            
//    var_Dump($document);            
    }
    
    public function uploadAction()
    {
   
     
        if (true == $this->request->hasFiles() && $this->request->isPost()) 
          {
        
            $upload_dir = __DIR__ . '/../../public/uploads/';
            echo $upload_dir;
/**            if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755);
            } */
            foreach ($this->request->getUploadedFiles() as $file) {
                $file->moveTo($upload_dir . $file->getName());
                $this->flashSession->success($file->getName().' has been successfully uploaded.');
            }
//           $this->response->redirect('media/add');
        }  
        
    }
    

 public function preparecityAction(){
        
        $numberPage = 1;
        
//        $document = Document::find();        
//        $export = '';
//        $path = $upload_dir . $file->getName();
//        $path = "Location-Country-Coordinate-213-651.txt";
        $path = "locations_list.csv";
//        echo($file->getName());
//        $path = $filename; 
	
//        $path = "/uploads/1.csv";
        $fp = fopen($path, "r");

	$buf = "";
	/* Make sure the file was succesfully opened */
	if(!$fp)
	{
		$fp = fopen($path, 'c');
	}
	else	
	{
		/* Loop over the file storing the file into a buffer */
		while(!feof($fp))
			$buf .= fread($fp, 4096);
	}
	fclose($fp);        
    
        $trans_temp = explode("\n", $buf);	
	/* Unset buffer since we have the data in an array now */
	unset($buf);
        
//        die(var_dump($trans_temp));
        
        foreach($trans_temp as $trans)
	{
            $trans = trim($trans);
            echo $trans.'<BR>';
//            $trans .= ",";
//            echo $trans.'<BR>';
	    $tran = explode("~", $trans); 
//         die(var_dump($tran));
            
            $CountryName = strtoupper($tran[3]);
//            $CountryCode = strtoupper($tran[3]);
//            echo $CountryName.'<BR>';
            
            $country = Country::find(" CountryName = '$CountryName' ");
        
            if ( count($country) == 0) {
                echo 'Unos '.$CountryName.'<BR>';

                $country = new Country();
                $country->CountryName = $CountryName;
//                $country->CountryCode = $CountryCode;
                
                if ($country->save() == false) {
                    foreach ($country->getMessages() as $message) {
                        $this->flash->error($message);
                        }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "new",
                        ]
                     );
                } 
            } 
//            echo 'Hey!';
            
            $country = Country::findFirst(" CountryName = '$CountryName' ");
            $ID_Country = $country->ID_Country;  
  
            
            $CityName = $tran[0];
            if ( $CityName == '' ) $CityName = $tran[3];
            $LAT = $tran[1];
            $LON = $tran[2];
            echo $CityName.' - '.$LAT.' - '.$LON.'<BR>';

//            if ( $ID_Country == 77 ) die(var_dump($tran));

            $city = City::findFirst(" CityName = '$CityName' ");
            
            if ( !$city ) {              
                $city = new City();              
                echo $CityName.' upis grada <BR>';
                $city->CityName = $CityName;
                $city->ID_Country = $ID_Country;
                $city->LATITUDE = $LAT;
                $city->LONGITUDE = $LON;
//           die(var_dump($city));
            } else {
                $city->ID_Country = $ID_Country;
                $city->LATITUDE = $LAT;
                $city->LONGITUDE = $LON;
            }
//            var_dump($city);

//            die(var_dump($city));
            if ($city->save() == false) {
                foreach ($city->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "new",
                    ]
                );
            } 
                   
	 } 

//    $this->view->form = new DocumentFullForm($document, array('edit' => true));            
//    var_Dump($document);            
    }
    
    
    public function documentcityAction(){
        
        $numberPage = 1;
        
//        $document = Document::find();        
//        $export = '';
//        $path = $upload_dir . $file->getName();
        $path = "locations_impacts_export.csv";
//          $path = "Document - Location.txt";
//        echo($file->getName());
//        $path = $filename; 
	
//        $path = "/uploads/1.csv";
        $fp = fopen($path, "r");

	$buf = "";
	/* Make sure the file was succesfully opened */
	if(!$fp)
	{
		$fp = fopen($path, 'c');
	}
	else	
	{
		/* Loop over the file storing the file into a buffer */
		while(!feof($fp))
			$buf .= fread($fp, 4096);
	}
	fclose($fp);        
    
        $trans_temp = explode("\n", $buf);	
	/* Unset buffer since we have the data in an array now */
	unset($buf);
    
        foreach($trans_temp as $trans)
	{
            
            $tran_cities = explode("|", $trans); 
            $ID_Doc = trim($tran_cities[0]);
            $number =0;
            $doc_city = ''; // list of cities for document
    
            $tran_city_new = explode(";", $tran_cities[1]);           
            
            foreach($tran_city_new as $tran_city) {
                $number++;
//                $tran_data = explode(",", $tran_city); // Data is tab delimited                           
                $tran_data = explode("~", $tran_city); // Data is tab delimited                           

                if ( $number == 1) {
//                  $ID_Doc = trim($tran_data[0]);
                    $CityName = trim($tran_data[0]);
                    if ( $CityName == '' ) $CityName = trim($tran_data[3]);
                    $CountryName = trim($tran_data[3]);
                    $doc_city .= $CityName;
                } else {
                    $CityName = trim($tran_data[0]);
                    if ( $CityName == '' ) $CityName = trim($tran_data[3]);
                    $CountryName = trim($tran_data[3]);
                    $doc_city .= ";".$CityName;            
                }
                echo $ID_Doc.' - '.$CityName.'<BR>'; 
    
                $document = Document::find(" ID_Doc = '$ID_Doc'");
                $city = City::findFirst(" CityName = '$CityName'");               

                if ( !$city ) {
                    echo 'Nema grada:'.$CityName.'<BR>';
                    die(var_dump($city));
                    $country = Country::findFirst(" CountryName = '$CountryName' ");
  
                   if ( count($country) == 0) {
                echo 'Nema zemlje:'.$CountryName.'<BR>';
                die(var_dump($city)); 
                        $country = new Country();
                        $country->CountryName = $CountryName;                        
                
                        if ($country->save() == false) {
                            foreach ($country->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                            
                            return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "new",
                                ]
                            );
                        } 
                    }
                  
                    $country = Country::findFirst(" CountryName = '$CountryName' ");
                    $ID_Country = $country->ID_Country;  
            
//                    echo $CityName.'<BR>';
            
                    $city = City::findFirst(" CityName = '$CityName' ");
            
                    if ( !$city ) {              
                        $city = new City();              
                        echo $CityName.' upis grada <BR>';
                        $city->CityName = $CityName;
                        $city->ID_Country = $ID_Country;
                        $city->LATITUDE = 0;
                        $city->LONGITUDE = 0;
  
                       if ($city->save() == false) {
                            foreach ($city->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                            
                            return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "new",
                                ]
                            );
                        }     
                    }
                }
                
                $city = City::findFirst(" CityName = '$CityName' ");    
                $ID_City = $city->ID_City;
//                echo $ID_Doc.' - '.$ID_City.'<BR>';
                $doccity = Doccity::findFirst("(ID_Doc = '$ID_Doc' AND ID_City ='$ID_City')");

                if ( !$doccity ) {

                    $query = "INSERT INTO doccity (ID_Doc,ID_City) VALUES ($ID_Doc,$ID_City)";
//                    echo $query;
                    $resultGeneral = $this->db->query($query);
                    
                }
            
        $doccity = Doccity::find("ID_Doc = '$ID_Doc'");
//   die(var_dump($doccity));

        $city_list = '';
        
        if ( count($doccity) != 0 ) {
            $i = 0;
            foreach ($doccity as $doccity_data){
                $ID_City = $doccity_data->ID_City;
                $city = City::find(" ID_City = '$ID_City'");
                foreach ($city as $city_data){
                    $CityName = $city_data->CityName;
                    $i++;
                    if ($i == 1) {
                        $city_list = $city_list.$CityName;
                    } else {
                        $city_list = $city_list.'; '.$CityName;
                    }
                }
        }
        echo $ID_Doc.' - '.$city_list.'<BR>';        
          
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->city = $city_list;

        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
          }                
        }         
      } 
//      die(var_dump($tran_data));
     }           
//    $this->view->form = new DocumentFullForm($document, array('edit' => true));            
//    var_Dump($document);            
    }
   
    public function documenttransvarAction(){
        
      $numberPage = 1;               
        
//        $document = Document::find();        
//        $export = '';
//        $path = $upload_dir . $file->getName();
        $path = "document_locations_impacts_export_050721.txt";
//          $path = "Document - Location.txt";
//        echo($file->getName());
//        $path = $filename; 
	
//        $path = "/uploads/1.csv";
        $fp = fopen($path, "r");

	$buf = "";
	/* Make sure the file was succesfully opened */
	if(!$fp)
	{
		$fp = fopen($path, 'c');
	}
	else	
	{
		/* Loop over the file storing the file into a buffer */
		while(!feof($fp))
			$buf .= fread($fp, 4096);
	}
	fclose($fp);        
    
        $trans_temp = explode("\n", $buf);	
	/* Unset buffer since we have the data in an array now */
	unset($buf);
    
        foreach($trans_temp as $trans)
	{

            $tran_doc = explode("|", $trans); 

            $ID_Doc = trim($tran_doc[0]);
            $Transvar = trim($tran_doc[2]);
            $Socialimpact = trim($tran_doc[3]);
            $Strength = trim($tran_doc[4]);
            $Keywordtv = trim($tran_doc[5]);

            $tran_transvar = explode(";", $Transvar); 
            $tran_socialimpact = explode(";", $Socialimpact); 
            $tran_strength = explode(";", $Strength); 
            $tran_keywordtv = explode(";", $Keywordtv); 
   
            $number =0;
            $transvar_list = array();
            $socialimpact_list = array();
            $strength = array();
            $keywordtv_list = array();
            $transvar_doc = '';
            $keywordtv_doc = '';
        if ( $ID_Doc > 475 ) {   
            if ( strlen($Transvar) != 0 ) {

                foreach($tran_transvar as $tran_transvar_new) {
                                         
                $transvar_list[$number] = $tran_transvar[$number];
                $socialimpact_list[$number] = $tran_socialimpact[$number];
                $strength_list[$number] = $tran_strength[$number];
                $keywordtv_list[$number] = $tran_keywordtv[$number];
                $number++;   
              }           
            
/**            echo $number.'<BR>';
            for($i=0; $i<$number; $i++) echo  $transvar_list[$i].' -> ';
            echo '<BR>';
            for($i=0; $i<$number; $i++) echo  $keywordtv_list[$i].' -> ';
            echo '<BR>'; */
            for($i=0; $i<$number; $i++) {
                
                $transvar_doc .= $transvar_list[$i].'~';

                $tran_keywordtv_all = explode("~", $keywordtv_list[$i]);
//                echo $ID_Doc.' - '.$transvar_doc.'<BR>'; 
                
                $transitionvar = Transitionvar::findFirst(" TransvarName = '$transvar_list[$i]' ");                

                    if ( !$transitionvar ) {              
                        $transitionvar = new Transitionvar();              
                        $transitionvar->TransvarName = $transvar_list[$i];
                
                       if ($transitionvar->save() == false) {
                            foreach ($transitionvar->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                            
                            return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "new",
                                ]
                            );
                        }     
                    }
                $transitionvar = Transitionvar::findFirst(" TransvarName = '$transvar_list[$i]' ");                
                $ID_Transvar = $transitionvar->ID_Transvar;
                
                foreach($tran_keywordtv_all as $tran_keywordtv_new) {
                    
                    $tran_keywordtv_new = trim($tran_keywordtv_new);
                    $keywordtv_doc .= $tran_keywordtv_new.';';
                    
                    $keywordtv = Keywordtv::findFirst(" KeywordtvName = '$tran_keywordtv_new' ");                

                    if ( !$keywordtv ) {              
                        $keywordtv = new Keywordtv();              
                        $keywordtv->KeywordtvName = $tran_keywordtv_new;
                
                       if ($keywordtv->save() == false) {
                            foreach ($keywordtv->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                            
                            return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "new",
                                ]
                            );
                        }     
                    }
                    $keywordtv = Keywordtv::findFirst(" KeywordtvName = '$tran_keywordtv_new' ");                
                    $ID_Keywordtv = $keywordtv->ID_Keywordtv;           
 
                    $transitionvarkeywordtv = Transitionvarkeywordtv::findFirst("( ID_Doc = '$ID_Doc' AND ID_Transvar = '$ID_Transvar' AND ID_Keywordtv ='$ID_Keywordtv')");
                
                    if ( !$transitionvarkeywordtv ) {              
                        $transitionvarkeywordtv = new Transitionvarkeywordtv();              
                        $transitionvarkeywordtv->ID_Doc = $ID_Doc;
                        $transitionvarkeywordtv->ID_Transvar = $ID_Transvar;
                        $transitionvarkeywordtv->ID_Keywordtv = $ID_Keywordtv;

//                        echo $ID_Doc.' - '.$ID_Transvar.' - '.$Id_Keywordtv.'<BR>';
                        if ($transitionvarkeywordtv->save() == false) {
                            foreach ($transitionvarkeywordtv->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                            
                            return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "new",
                                ]
                            );
                        }     
                    }
                }

                $keywordtv_doc .= '~';
                $ID_SocImpact = $socialimpact_list[$i] + 1;
//                echo $ID_Doc.' - '.$keywordtv_doc.' - '.$ID_SocImpact.'<BR>';

                $transitionvarsocialimpact = Transitionvarsocialimpact::findFirst("(ID_Transvar = '$ID_Transvar' AND ID_SocImpact ='$ID_SocImpact')");
                
                    if ( !$transitionvarsocialimpact ) {              
                        $transitionvarsocialimpact = new Transitionvarsocialimpact();              
                        $transitionvarsocialimpact->ID_Transvar = $ID_Transvar;
                        $transitionvarsocialimpact->ID_SocImpact = $ID_SocImpact;
                
                       if ($transitionvarsocialimpact->save() == false) {
                            foreach ($transitionvarsocialimpact->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                            
                            return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "new",
                                ]
                            );
                        }     
                    }
                 
                $doctransitionvar = Doctransitionvar::findFirst("( ID_Doc ='$ID_Doc' AND ID_Transvar = '$ID_Transvar' )");
                
                
                    if ( !$doctransitionvar ) {              
                        $Strength_value = $strength_list[$i];
                        $doctransitionvar = new Doctransitionvar();              
                        $doctransitionvar->ID_Doc = $ID_Doc;
                        $doctransitionvar->ID_Transvar = $ID_Transvar;
                        $doctransitionvar->Strength = $Strength_value;
                                        
                       if ($doctransitionvar->save() == false) {
                            foreach ($doctransitionvar->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                            
                            return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "new",
                                ]
                            );
                        }     
                    }    
      
                }   
             
           }
    }       
        if ( $ID_Doc > 476 ) {
            echo $ID_Doc.' - '.$transvar_doc.'<BR>';
            echo '<BR>';
            echo $keywordtv_doc.'<BR>';      
            $documentextented = Documentextented::findFirst(" ID_Doc = '$ID_Doc'");
//        die(var_dump($documentextented));         
            if ( !$documentextented ) {              
                        $documenextented = new Documentextented();              
                        $documenextented->ID_Doc = $ID_Doc;
   
                                        
                       if ($documenextented->save() == false) {
                            foreach ($documenextented->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                            
                            return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "new",
                                ]
                            );
                        }     
           } else {
                    $documentextented->ID_Doc = $ID_Doc;
//                    $documenextented->docview = $doc->docivew;
                    $documentextented->transitionvar = $transvar_doc;
                    $documentextented->keywordtv = $keywordtv_doc;
          
                    if ($documentextented->save() == false) {
                            foreach ($documentextented->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                            
                            return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "new",
                                ]
                            );
                        }
               }
        }   
        }               
    }             


    }
