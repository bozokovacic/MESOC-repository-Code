<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class TypeForm extends Form
{
    /**
     * Initialize the type form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Type");
            $this->add($element->setLabel("TYPE ID"));
        } else {
            $this->add(new Hidden("ID_Type"));
        }

        $DocType = new Text("DocType");
        $DocType->setLabel("DOCUMENT TYPE");
        $DocType->setFilters(['striptags', 'string']);
        $DocType->addValidators([
            new PresenceOf([
                'message' => 'Type name is required.'
            ])
        ]);
        $this->add($DocType);
                     
    }
}
