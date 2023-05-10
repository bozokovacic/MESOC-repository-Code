<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class LitareaForm extends Form
{
    /**
     * Initialize the companies form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_LitArea");
            $this->add($element->setLabel("LITERATURE AREA ID"));
        } else {
            $this->add(new Hidden("ID_LitArea"));
        }

        $LiteratureArea = new Text("LiteratureArea");
        $LiteratureArea->setLabel("LITERATURE AREA");
        $LiteratureArea->setFilters(['striptags', 'string']);
        $LiteratureArea->addValidators([
            new PresenceOf([
                'message' => 'Literature Area is needed.'
            ])
        ]);
        $this->add($LiteratureArea);

    }
}
