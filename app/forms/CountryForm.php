<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class CountryForm extends Form
{
    /**
     * Initialize the type form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Country");
            $this->add($element->setLabel("COUNTRY ID"));
        } else {
            $this->add(new Hidden("ID_Country"));
        }

        $CountryCode = new Text("CountryCode");
        $CountryCode->setLabel("COUNTY CODE");
        $CountryCode->setFilters(['striptags', 'string']);
        $CountryCode->addValidators([
            new PresenceOf([
                'message' => 'Country Code name is required.'
            ])
        ]);
        $this->add($CountryCode);

        $CountryName = new Text("CountryName");
        $CountryName->setLabel("COUNTY");
        $CountryName->setFilters(['striptags', 'string']);
        $CountryName->addValidators([
            new PresenceOf([
                'message' => 'Country Name name is required.'
            ])
        ]);
        $this->add($CountryName);
        
    }
}
