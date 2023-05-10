<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;

class OrganisationForm extends Form
{
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Organisation");
            $this->add($element->setLabel("ORGANISATION ID"));
        } else {
            $this->add(new Hidden("ID_Organisation"));
        }

        $OrgName = new Text("OrgName");
        $OrgName->setLabel("ORGANISATION");
        $OrgName->setFilters(['striptags', 'string']);
        $OrgName->addValidators([
            new PresenceOf([
                'message' => 'Institution is required'
            ])
        ]);
        $this->add($OrgName);

        $OrgAdress = new Text("OrgAdress");
        $OrgAdress->setLabel("ORGANISATION ADRESS");
        $OrgAdress->setFilters(['striptags', 'string']);
        $OrgAdress->addValidators([
/**            new PresenceOf([
                'message' => 'Institution adress is required.'
            ])  */
        ]);
        $this->add($OrgAdress);

        $type = new Select('ID_City', City::find(), [
            'using'      => ['ID_City', 'CityName'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $type->addValidators([
            new PresenceOf([
                'message' => 'City is required.'
            ])
        ]);
        
        $type->setLabel('City');
        $this->add($type);

        $type = new Select('ID_Country', Country::find(), [
            'using'      => ['ID_Country', 'CountryName'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $type->addValidators([
            new PresenceOf([
                'message' => 'Country is required.'
            ])
        ]);
        
        $type->setLabel('Country');
        $this->add($type);

    }
}
