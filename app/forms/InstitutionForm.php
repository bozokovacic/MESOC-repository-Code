<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;

class InstitutionForm extends Form
{
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Institution");
            $this->add($element->setLabel("INSTITUTION ID"));
        } else {
            $this->add(new Hidden("ID_Institution"));
        }

        $InstName = new Text("InstName");
        $InstName->setLabel("INSTITUTION");
        $InstName->setFilters(['striptags', 'string']);
        $InstName->addValidators([
            new PresenceOf([
                'message' => 'Institution is required'
            ])
        ]);
        $this->add($InstName);

        $InstAdress = new Text("InstAdress");
        $InstAdress->setLabel("INSTITUTION ADRESS");
        $InstAdress->setFilters(['striptags', 'string']);
        $InstAdress->addValidators([
/**            new PresenceOf([
                'message' => 'Institution adress is required.'
            ])  */
        ]);
        $this->add($InstAdress);
        
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
