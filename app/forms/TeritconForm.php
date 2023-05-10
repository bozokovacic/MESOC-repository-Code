<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class TeritconForm extends Form
{
    /**
     * Initialize the type form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_TeritCon");
            $this->add($element->setLabel("TERRITORIAL CONTEXT ID"));
        } else {
            $this->add(new Hidden("ID_TeritCon"));
        }

        $TeritCon = new Text("TeritCon");
        $TeritCon->setLabel("TERRITORIAL CONTEXT");
        $TeritCon->setFilters(['striptags', 'string']);
        $TeritCon->addValidators([
            new PresenceOf([
                'message' => 'Region name is required.'
            ])
        ]);
        $this->add($TeritCon);
        
    }
}
