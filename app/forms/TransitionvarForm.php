<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class TransitionvarForm extends Form
{
    /**
     * Initialize the Transitionvar form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Transvar");
            $this->add($element->setLabel("Transition variable ID"));
        } else {
            $this->add(new Hidden("ID_Transvar"));
        }

        $TransvarName = new Text("TransvarName");
        $TransvarName->setLabel("Transition variable name");
        $TransvarName->setFilters(['striptags', 'string']);
        $TransvarName->addValidators([
/**            new PresenceOf([
                'message' => 'Transitionvar name is required.'
            ]) */
        ]);
        $this->add($TransvarName);
        
        $TransvarDescription = new Text("TransvarDescription");
        $TransvarDescription->setLabel("Transition description");
        $TransvarDescription->setFilters(['striptags', 'string']);
        $TransvarDescription->addValidators([
/**            new PresenceOf([
                'message' => 'Transitionvar name is required.'
            ]) */
        ]);
        $this->add($TransvarDescription);

   	}
}
