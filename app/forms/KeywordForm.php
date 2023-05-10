<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class KeywordForm extends Form
{
    /**
     * Initialize the Sector form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Keyword");
            $this->add($element->setLabel("Keyword ID"));
        } else {
            $this->add(new Hidden("ID_Keyword"));
        }

        $KeywordName = new Text("KeywordName");
        $KeywordName->setLabel("Keyword ");
        $KeywordName->setFilters(['striptags', 'string']);
        $KeywordName->addValidators([
            new PresenceOf([
                'message' => 'Keyword is required.'
            ])
        ]);
        $this->add($KeywordName);

        $KeywordDescription = new Text("KeywordDescription");
        $KeywordDescription->setLabel("Keyword description");
        $KeywordDescription->setFilters(['striptags', 'string']);
        $KeywordDescription->addValidators([
            new PresenceOf([
                'message' => 'Keyword description is required.'
            ])
        ]);
        $this->add($KeywordDescription);

   	}
}
