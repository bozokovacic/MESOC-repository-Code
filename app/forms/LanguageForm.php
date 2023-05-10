<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;

class LanguageForm extends Form
{
    /**
     * Initialize the grupa djela form
     */
    public function initialize($entity = null, $options = array())
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Language");
            $this->add($element->setLabel("LANGUAGE ID"));
        } else {
            $this->add(new Hidden("ID_Language"));
        }

        $Language = new Text("Language");
        $Language->setLabel("LANGUAGE");
        $Language->setFilters(['striptags', 'string']);
        $Language->addValidators([
            new PresenceOf([
                'message' => 'Language is required'
            ])
        ]);
        $this->add($Language);
	
    }
}
