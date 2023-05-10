<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class CityForm extends Form
{
    /**
     * Initialize the type form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_City");
            $this->add($element->setLabel("CITY ID"));
        } else {
            $this->add(new Hidden("ID_City"));
        }

        $CityCode = new Text("CityCode");
        $CityCode->setLabel("CITY CODE");
        $CityCode->setFilters(['striptags', 'string']);
        $CityCode->addValidators([
            new PresenceOf([
                'message' => 'City code is required.'
            ])
        ]);
        $this->add($CityCode);
        
        $CityName = new Text("CityName");
        $CityName->setLabel("CITY");
        $CityName->setFilters(['striptags', 'string']);
        $CityName->addValidators([
            new PresenceOf([
                'message' => 'City name is required.'
            ])
        ]);
        $this->add($CityName);
    
        $type = new Select('ID_Country', Country::find(), [
            'using'      => ['ID_Country', 'CountryName'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
         ]);
            $type->addValidators([
                new PresenceOf([
                    'message' => 'Country name is required.'
                ])
         ]);

        $type->setLabel('COUNTRY');
        $this->add($type);
        
/**        $CityTeritCon = new Text("CityTeritCon");
        $CityTeritCon->setLabel("CITY TERIT. CONTEXT");
        $CityTeritCon->setFilters(['striptags', 'string']);
        $CityTeritCon->addValidators([
            new PresenceOf([
                'message' => 'City Terit. context is required.'
            ])  
        ]);  
        $this->add($CityTeritCon);  */
        
 /**       $ID_Country = new Text("ID_Country");
        $ID_Country->setLabel("Country ID");
        $ID_Country->setFilters(['striptags', 'string']);
        $ID_Country->addValidators([
            new PresenceOf([
                'message' => 'Country ID is required.'
            ])
        ]);
        $this->add($ID_Country); */
                     
    }
}
