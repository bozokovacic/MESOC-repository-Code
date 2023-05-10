<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Radio;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Forms\Element\File;

class TemplateForm extends Form
{
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Proposal");
            $this->add($element->setLabel("Template ID"));
        } else {
            $this->add(new Hidden("ID_Proposal"));
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

	$PubYear = new Select("PubYear",[
            '1990' => '1990',
            '1991' => '1991',
            '1992' => '1992',
            '1993' => '1993',
            '1994' => '1994',
            '1995' => '1995',
            '1996' => '1996',
            '1997' => '1997',
            '1998' => '1998',
            '1999' => '1999',
            '2000' => '2000',
            '2001' => '2001',
            '2002' => '2002',
            '2003' => '2003',
            '2004' => '2004',
            '2005' => '2005',
            '2006' => '2006',
            '2007' => '2007',
            '2008' => '2008',
            '2009' => '2009',
            '2010' => '2010',
            '2011' => '2011',
            '2012' => '2012',
            '2013' => '2013',
            '2014' => '2014',
            '2015' => '2015',
            '2016' => '2016',
            '2017' => '2017',
            '2018' => '2018',
            '2019' => '2019',
            '2020' => '2020',
            '2021' => '2021',
            '2022' => '2022'
         ]);
//      $PubYear->setFilters(['striptags', 'string']);
        $PubYear->setLabel("Year of publication ");
        $this->add($PubYear);
        
        $type = new Select( "OpenAccess", [
            'YES' => 'YES',
            'NO' => 'NO'
//            'emptyText'  => 'YES',
//            'emptyValue' => ''YES','NO''
        ]);
        $type->setLabel('Open Access');
        $this->add($type);
                
        $CountryPub = new Select("CountryPub", [
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
        $this->add($CountryPub);
        
        $type = new Select('ID_Language', Language::find(), [
            'using'      => ['ID_Language', 'Language'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
            ]);
        $type->setLabel('Language ID');
        $this->add($type);  
        
        $Summary = new TextArea("Summary");
        $Summary->setLabel("Summary");
        $Summary->setFilters(['striptags', 'string']);
        $Summary->addValidators([
              new PresenceOf([
                'message' => 'Summary is ruquired.'
            ])
        ]);
        
        $this->add($Summary);
              
/**        $type = new Select('ID_CultDomain', culturalDomain::find(), [
            'using'      => ['ID_CultDomain', 'CultDomainName'],
            'useEmpty'   => false,
            'emptyText'  => '...',
            'emptyValue' => '',
            'order'      => 'ID_CultDomain',
            'multiple'   => 'multiple'
        ]);
        $type->setLabel('Cultural Domain  (please enter numbers of cultural domain separated by comas): 1. Heritage 2. Archives Heritage 3. Libraries 4. Book and Press 5. Visual Arts 6. Performing Arts 7. Audiovisual and Multimedia 8. Architecture            9. Advertising 10. Art crafts');
        $this->add($type);  */
       
/**        $ID_CultDomain = new Select('ID_CultDomain', culturaldomain::find(), [
            'using'      => ['ID_CultDomain', 'CultDomainName'],
            'useEmpty'   => false,
            'emptyText'  => '...',
            'emptyValue' => '',
            'size'      => 10,
            'order'      => 'ID_CultDomain',
            'multiple'   => 'multiple'
        ]);
        $ID_CultDomain->setLabel('Cultural Domain  (please choose cultural domain).');
        $this->add($ID_CultDomain);    */
                
/**        $ID_SocImpact = new Select('ID_SocImpact', socialimpact::find(), [
            'using'      => ['ID_SocImpact', 'SocImpactName'],
            'useEmpty'   => false,
            'emptyText'  => '...',
            'emptyValue' => '',
            'size'      =>   3,
            'order'      => 'ID_SocImpact',
            'multiple'   => 'multiple'
        ]);
        $ID_SocImpact->setLabel('Social impact  (please choose social impact).');
        $this->add($ID_SocImpact);    */
                    
        $TransitionVar = new TextArea("TransitionVar");
        $TransitionVar->setLabel("Transition variables");
        $TransitionVar->setFilters(['striptags', 'string']);
        $TransitionVar->addValidators([
/**             new PresenceOf([
                'message' => 'Transition variables are ruquired.'
            ])  */
        ]);
        
        $this->add($TransitionVar); 
        
        $Keywords = new Text("Keywords");
        $Keywords->setLabel("Keywords");
        $Keywords->setFilters(['striptags', 'string']);
        $Keywords->addValidators([
            new PresenceOf([
                'message' => 'Keywords are ruquired.'
            ]) 
        ]);
        $this->add($Keywords);     
              
        $Links = new Text("Links");
        $Links->setLabel("Links");
        $Links->setFilters(['striptags', 'string']);
        $Links->addValidators([
            new PresenceOf([
                'message' => 'Links is ruquired.'
            ]) 
        ]); 
        
        $this->add($Links);
       
/**        $rememberMe = new Check('remember_me', array(
        'value' => 1,
        'class' => 'box'
        ));  
        
        $this->add($rememberMe);  */
    }
}
