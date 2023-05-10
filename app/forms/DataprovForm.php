<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class DataprovForm extends Form
{
    /**
     * Initialize the type form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_DataProv");
            $this->add($element->setLabel("DATA PROVIDERS ID"));
        } else {
            $this->add(new Hidden("ID_DataProv"));
        }

        $DataProvName = new Text("DataProvName");
        $DataProvName->setLabel("DATA PROVIDER");
        $DataProvName->setFilters(['striptags', 'string']);
        $DataProvName->addValidators([
            new PresenceOf([
                'message' => 'Data provider is required.'
            ])
        ]);
        $this->add($DataProvName);
        
    }
}
