<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class TechniqueForm extends Form
{
    /**
     * Initialize the technique form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Technique");
            $this->add($element->setLabel("TYPE Technique"));
        } else {
            $this->add(new Hidden("ID_Technique"));
        }

        $TechniqueName = new Text("TechniqueName");
        $TechniqueName->setLabel("TECHNIQUE");
        $TechniqueName->setFilters(['striptags', 'string']);
        $TechniqueName->addValidators([
            new PresenceOf([
                'message' => 'Technique name is required.'
            ])
        ]);
        $this->add($TechniqueName);
                     
    }
}
