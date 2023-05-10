<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;

class DocumentForm extends Form
{
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Doc");
            $this->add($element->setLabel("Document ID"));
        } else {
            $this->add(new Hidden("ID_Doc"));
        }
        
	$Title = new Text("Title");
        $Title->setLabel("Document title");
        $Title->setFilters(['striptags', 'string']);
        $Title->addValidators([
            new PresenceOf([
                'message' => 'Document title is required.'
            ]) 
        ]);
        
		$this->add($Title);
		
	$PubYear = new Text("PubYear");
        $PubYear->setLabel("Year of publication");
        $PubYear->setFilters(['striptags', 'string']);
        $PubYear->addValidators([
            new PresenceOf([
                'message' => 'Public year is ruquired.'
            ])
        ]);
        $this->add($PubYear);
        
        $Summary = new TextArea("Summary");
        $Summary->setLabel("Abstract");
        $Summary->setFilters(['striptags', 'string']);
        $Summary->addValidators([
        /**    new PresenceOf([
                'message' => 'Abstract is ruquired.'
            ]) */
        ]);
        
        $this->add($Summary);
	
/**        $CountryPub = new Select("CountryPub", [
                   'Arabic'=>'Arabic',
                   'Afganistan'=>'Afghanistan',
                   'Albania'=>'Albania',
                   'Algeria'=>'Algeria',
                   'American Samoa'=>'American Samoa',
                   'Andorra'=>'Andorra',
                   'Angola'=>'Angola',
                   'Anguilla'=>'Anguilla',
                   'Antigua & Barbuda'=>'Antigua & Barbuda',
                   'Argentina'=>'Argentina',
                   'Armenia'=>'Armenia',
                   'Aruba'=>'Aruba',
                   'Australia'=>'Australia',
                   'Austria'=>'Austria',
                   'Azerbaijan'=>'Azerbaijan',
                   'Bahamas'=>'Bahamas',
                   'Bahrain'=>'Bahrain',
                   'Bangladesh'=>'Bangladesh',
                   'Barbados'=>'Barbados',
                   'Belarus'=>'Belarus',
                   'Belgium'=>'Belgium',
                   'Belize'=>'Belize',
                   'Benin'=>'Benin',
                   'Bermuda'=>'Bermuda',
                   'Bhutan'=>'Bhutan',
                   'Bolivia'=>'Bolivia',
                   'Bonaire'=>'Bonaire',
                   'Bosnia & Herzegovina'=>'Bosnia & Herzegovina',
                   'Botswana'=>'Botswana',
                   'Brazil'=>'Brazil',
                   'British Indian Ocean Ter'=>'British Indian Ocean Ter',
                   'Brunei'=>'Brunei',
                   'Bulgaria'=>'Bulgaria',
                   'Burkina Faso'=>'Burkina Faso',
                   'Burundi'=>'Burundi',
                   'Cambodia'=>'Cambodia',
                   'Cameroon'=>'Cameroon',
                   'Canada'=>'Canada',
                   'Canary Islands'=>'Canary Islands',
                   'Cape Verde'=>'Cape Verde',
                   'Cayman Islands'=>'Cayman Islands',
                   'Central African Republic'=>'Central African Republic',
                   'Chad'=>'Chad',
                   'Channel Islands'=>'Channel Islands',
                   'Chile'=>'Chile',
                   'China'=>'China',
                   'Christmas Island'=>'Christmas Island',
                   'Cocos Island'=>'Cocos Island',
                   'Colombia'=>'Colombia',
                   'Comoros'=>'Comoros',
                   'Congo'=>'Congo',
                   'Cook Islands'=>'Cook Islands',
                   'Costa Rica'=>'Costa Rica',
                   'Cote DIvoire'=>'Cote DIvoire',
                   'Croatia'=>'Croatia',
                   'Cuba'=>'Cuba',
                   'Curaco'=>'Curacao',
                   'Cyprus'=>'Cyprus',
                   'Czech Republic'=>'Czech Republic',
                   'Denmark'=>'Denmark',
                   'Djibouti'=>'Djibouti',
                   'Dominica'=>'Dominica',
                   'Dominican Republic'=>'Dominican Republic',
                   'East Timor'=>'East Timor',
                   'Ecuador'=>'Ecuador',
                   'Egypt'=>'Egypt',
                   'El Salvador'=>'El Salvador',
                   'Equatorial Guinea'=>'Equatorial Guinea',
                   'Eritrea'=>'Eritrea',
                   'Estonia'=>'Estonia',
                   'Ethiopia'=>'Ethiopia',
                   'Falkland Islands'=>'Falkland Islands',
                   'Faroe Islands'=>'Faroe Islands',
                   'Fiji'=>'Fiji',
                   'Finland'=>'Finland',
                   'France'=>'France',
                   'French Guiana'=>'French Guiana',
                   'French Polynesia'=>'French Polynesia',
                   'French Southern Ter'=>'French Southern Ter',
                   'Gabon'=>'Gabon',
                   'Gambia'=>'Gambia',
                   'Georgia'=>'Georgia',
                   'Germany'=>'Germany',
                   'Ghana'=>'Ghana',
                   'Gibraltar'=>'Gibraltar',
                   'Great Britain'=>'Great Britain',
                   'Greece'=>'Greece',
                   'Greenland'=>'Greenland',
                   'Grenada'=>'Grenada',
                   'Guadeloupe'=>'Guadeloupe',
                   'Guam'=>'Guam',
                   'Guatemala'=>'Guatemala',
                   'Guinea'=>'Guinea',
                   'Guyana'=>'Guyana',
                   'Haiti'=>'Haiti',
                   'Hawaii'=>'Hawaii',
                   'Honduras'=>'Honduras',
                   'Hong Kong'=>'Hong Kong',
                   'Hungary'=>'Hungary',
                   'Iceland'=>'Iceland',
                   'Indonesia'=>'Indonesia',
                   'India'=>'India',
                   'Iran'=>'Iran',
                   'Iraq'=>'Iraq',
                   'Ireland'=>'Ireland',
                   'Isle of Man'=>'Isle of Man',
                   'Israel'=>'Israel',
                   'Italy'=>'Italy',
                   'Jamaica'=>'Jamaica',
                   'Japan'=>'Japan',
                   'Jordan'=>'Jordan',
                   'Kazakhstan'=>'Kazakhstan',
                   'Kenya'=>'Kenya',
                   'Kiribati'=>'Kiribati',
                   'Korea North'=>'Korea North',
                   'Korea Sout'=>'Korea South',
                   'Kuwait'=>'Kuwait',
                   'Kyrgyzstan'=>'Kyrgyzstan',
                   'Laos'=>'Laos',
                   'Latvia'=>'Latvia',
                   'Lebanon'=>'Lebanon',
                   'Lesotho'=>'Lesotho',
                   'Liberia'=>'Liberia',
                   'Libya'=>'Libya',
                   'Liechtenstein'=>'Liechtenstein',
                   'Lithuania'=>'Lithuania',
                   'Luxembourg'=>'Luxembourg',
                   'Macau'=>'Macau',
                   'Macedonia'=>'Macedonia',
                   'Madagascar'=>'Madagascar',
                   'Malaysia'=>'Malaysia',
                   'Malawi'=>'Malawi',
                   'Maldives'=>'Maldives',
                   'Mali'=>'Mali',
                   'Malta'=>'Malta',
                   'Marshall Islands'=>'Marshall Islands',
                   'Martinique'=>'Martinique',
                   'Mauritania'=>'Mauritania',
                   'Mauritius'=>'Mauritius',
                   'Mayotte'=>'Mayotte',
                   'Mexico'=>'Mexico',
                   'Midway Islands'=>'Midway Islands',
                   'Moldova'=>'Moldova',
                   'Monaco'=>'Monaco',
                   'Mongolia'=>'Mongolia',
                   'Montserrat'=>'Montserrat',
                   'Morocco'=>'Morocco',
                   'Mozambique'=>'Mozambique',
                   'Myanmar'=>'Myanmar',
                   'Nambia'=>'Nambia',
                   'Nauru'=>'Nauru',
                   'Nepal'=>'Nepal',
                   'Netherland Antilles'=>'Netherland Antilles',
                   'Netherlands'=>'Netherlands (Holland, Europe)',
                   'Nevis'=>'Nevis',
                   'New Caledonia'=>'New Caledonia',
                   'New Zealand'=>'New Zealand',
                   'Nicaragua'=>'Nicaragua',
                   'Niger'=>'Niger',
                   'Nigeria'=>'Nigeria',
                   'Niue'=>'Niue',
                   'Norfolk Island'=>'Norfolk Island',
                   'Norway'=>'Norway',
                   'Oman'=>'Oman',
                   'Pakistan'=>'Pakistan',
                   'Palau Island'=>'Palau Island',
                   'Palestine'=>'Palestine',
                   'Panama'=>'Panama',
                   'Papua New Guinea'=>'Papua New Guinea',
                   'Paraguay'=>'Paraguay',
                   'Peru'=>'Peru',
                   'Phillipines'=>'Philippines',
                   'Pitcairn Island'=>'Pitcairn Island',
                   'Poland'=>'Poland',
                   'Portugal'=>'Portugal',
                   'Puerto Rico'=>'Puerto Rico',
                   'Qatar'=>'Qatar',
                   'Republic of Montenegro'=>'Republic of Montenegro',
                   'Republic of Serbia'=>'Republic of Serbia',
                   'Reunion'=>'Reunion',
                   'Romania'=>'Romania',
                   'Russia'=>'Russia',
                   'Rwanda'=>'Rwanda',
                   'St Barthelemy'=>'St Barthelemy',
                   'St Eustatius'=>'St Eustatius',
                   'St Helena'=>'St Helena',
                   'St Kitts-Nevis'=>'St Kitts-Nevis',
                   'St Lucia'=>'St Lucia',
                   'St Maarten'=>'St Maarten',
                   'St Pierre & Miquelon'=>'St Pierre & Miquelon',
                   'St Vincent & Grenadines'=>'St Vincent & Grenadines',
                   'Saipan'=>'Saipan',
                   'Samoa'=>'Samoa',
                   'Samoa American'=>'Samoa American',
                   'San Marino'=>'San Marino',
                   'Sao Tome & Principe'=>'Sao Tome & Principe',
                   'Saudi Arabia'=>'Saudi Arabia',
                   'Senegal'=>'Senegal',
                   'Seychelles'=>'Seychelles',
                   'Sierra Leone'=>'Sierra Leone',
                   'Singapore'=>'Singapore',
                   'Slovakia'=>'Slovakia',
                   'Slovenia'=>'Slovenia',
                   'Solomon Islands'=>'Solomon Islands',
                   'Somalia'=>'Somalia',
                   'South Africa'=>'South Africa',
                   'Spain'=>'Spain',
                   'Sri Lanka'=>'Sri Lanka',
                   'Sudan'=>'Sudan',
                   'Suriname'=>'Suriname',
                   'Swaziland'=>'Swaziland',
                   'Sweden'=>'Sweden',
                   'Switzerland'=>'Switzerland',
                   'Syria'=>'Syria',
                   'Tahiti'=>'Tahiti',
                   'Taiwan'=>'Taiwan',
                   'Tajikistan'=>'Tajikistan',
                   'Tanzania'=>'Tanzania',
                   'Thailand'=>'Thailand',
                   'Togo'=>'Togo',
                   'Tokelau'=>'Tokelau',
                   'Tonga'=>'Tonga',
                   'Trinidad & Tobago'=>'Trinidad & Tobago',
                   'Tunisia'=>'Tunisia',
                   'Turkey'=>'Turkey',
                   'Turkmenistan'=>'Turkmenistan',
                   'Turks & Caicos Is'=>'Turks & Caicos Is',
                   'Tuvalu'=>'Tuvalu',
                   'Uganda'=>'Uganda',
                   'United Kingdom'=>'United Kingdom',
                   'Ukraine'=>'Ukraine',
                   'United Arab Erimates'=>'United Arab Emirates',
                   'United States of America'=>'United States of America',
                   'Uraguay'=>'Uruguay',
                   'Uzbekistan'=>'Uzbekistan',
                   'Vanuatu'=>'Vanuatu',
                   'Vatican City State'=>'Vatican City State',
                   'Venezuela'=>'Venezuela',
                   'Vietnam'=>'Vietnam',
                   'Virgin Islands (Brit)'=>'Virgin Islands (Brit)',
                   'Virgin Islands (USA)'=>'Virgin Islands (USA)',
                   'Wake Island'=>'Wake Island',
                   'Wallis & Futana Is'=>'Wallis & Futana Is',
                   'Yemen'=>'Yemen',
                   'Zaire'=>'Zaire',
                   'Zambia'=>'Zambia',
                   'Zimbabwe'=>'Zimbabwe',
        ]);
               
        $CountryPub->setLabel("Country publication");
        $this->add($CountryPub);  */
       
        $type = new Select('ID_Language', Language::find(), [
            'using'      => ['ID_Language', 'Language'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $type->setLabel('Language');
        $this->add($type);  
        
        $type = new Select('ID_Type', Type::find(), [
            'using'      => ['ID_Type', 'DocType'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $type->setLabel('Document Type');
        $this->add($type);
        
	$type = new Select('ID_Category', Category::find(), [
            'using'      => ['ID_Category', 'CategoryName'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $type->setLabel('Category Type');
        $this->add($type);        

        $Author = new Text("Author");
        $Author->setLabel("Author");
        $Author->setFilters(['striptags', 'string']);
        $Author->addValidators([
        /**    new PresenceOf([
                'message' => 'Biblio. reference is ruquired.'
            ]) */
        ]);
        
        $Keywords = new Text("Keywords");
        $Keywords->setLabel("Keywords");
        $Keywords->setFilters(['striptags', 'string']);
        $Keywords->addValidators([
            new PresenceOf([
                'message' => 'Keywords is ruquired.'
            ])
        ]);
        $this->add($Keywords);
        $this->add($Author);
        
        $Institution = new Text("Institution");
        $Institution->setLabel("Institution");
        $Institution->setFilters(['striptags', 'string']);
        $Institution->addValidators([
        /**    new PresenceOf([
                'message' => 'Biblio. reference is ruquired.'
            ]) */
        ]);
        
        $this->add($Institution);
        
        $Technique = new Text("Technique");
        $Technique->setLabel("Technique");
        $Technique->setFilters(['striptags', 'string']);
        $Technique->addValidators([
        /**    new PresenceOf([
                'message' => 'Biblio. reference is ruquired.'
            ]) */
        ]);
        
        $this->add($Technique);
        
        $Searchdatabase = new Text("Searchdatabase");
        $Searchdatabase->setLabel("Search database");
        $Searchdatabase->setFilters(['striptags', 'string']);
        $Searchdatabase->addValidators([
        /**    new PresenceOf([
                'message' => 'Biblio. reference is ruquired.'
            ]) */
        ]);
        
        $this->add($Searchdatabase);

        $DataProviders = new Text("DataProviders");
        $DataProviders->setLabel("Data providers");
        $DataProviders->setFilters(['striptags', 'string']);
        $DataProviders->addValidators([
        /**    new PresenceOf([
                'message' => 'Biblio. reference is ruquired.'
            ]) */
        ]);
        
        $this->add($DataProviders);
        
/**        $Methodology = new Text("Methodology");
        $Methodology->setLabel("Methodology");
        $Methodology->setFilters(['striptags', 'string']);
        $Methodology->addValidators([
            new PresenceOf([
                'message' => 'Methodology year is ruquired.'
            ])
        ]); 
        
        $this->add($Methodology); */
                
/**        $type = new Select('ID_Sector', Sector::find(), [
            'using'      => ['ID_Sector', 'SectorName'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $type->setLabel('Sector');
        $this->add($type);  */
        
/*        $type = new Select('ID_LitArea', LitArea::find(), [
            'using'      => ['ID_LitArea', 'LiteratureArea'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $type->setLabel('Literature Area');
        $this->add($type);   */

        $city = new Text("city");
        $city->setLabel("City");
        $city->setFilters(['striptags', 'string']);
        $city->addValidators([
/**            new PresenceOf([
                'message' => 'City is ruquired.'
            ]) */
        ]);  
                       
        $this->add($city);                      
        
        $DOI = new Text("DOI");
        $DOI->setLabel("DOI");
        $DOI->setFilters(['striptags', 'string']);
        $DOI->addValidators([
        /**    new PresenceOf([
                'message' => 'Biblio. reference is ruquired.'
            ]) */
        ]);
                       
        $this->add($DOI);
        
     
    }
}
