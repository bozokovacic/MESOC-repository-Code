<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class RelevanceForm extends Form
{
    /**
     * Initialize the relevance form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Relevance");
            $this->add($element->setLabel("TYPE ID"));
        } else {
            $this->add(new Hidden("ID_Relevance"));
        }

        $Relevance = new Text("Relevance");
        $Relevance->setLabel("RELEVANCE NAME");
        $Relevance->setFilters(['striptags', 'string']);
        $Relevance->addValidators([
            new PresenceOf([
                'message' => 'Relevance name is required.'
            ])
        ]);
        $this->add($Relevance);
                     
    }
}
