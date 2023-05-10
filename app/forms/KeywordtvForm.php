<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class KeywordtvForm extends Form
{
    /**
     * Initialize the Sector form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Keywordtv");
            $this->add($element->setLabel("Keyword transition variable ID"));
        } else {
            $this->add(new Hidden("ID_Keywordtv"));
        }

        $KeywordtvName = new Text("KeywordtvName");
        $KeywordtvName->setLabel("Keyword transition variable");
        $KeywordtvName->setFilters(['striptags', 'string']);
        $KeywordtvName->addValidators([
            new PresenceOf([
                'message' => 'Keyword transition variable is required.'
            ])
        ]);
        $this->add($KeywordtvName);

        $KeywordtvDescription = new Text("KeywordtvDescription");
        $KeywordtvDescription->setLabel("Keyword transition variable description");
        $KeywordtvDescription->setFilters(['striptags', 'string']);
        $KeywordtvDescription->addValidators([
/**            new PresenceOf([
                'message' => 'Keyword transition variable description is required.'
            ]) */
        ]);
        $this->add($KeywordtvDescription);

   	}
}
