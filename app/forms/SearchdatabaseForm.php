<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class SearchdatabaseForm extends Form
{
    /**
     * Initialize the type form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Database");
            $this->add($element->setLabel("DATABASE ID"));
        } else {
            $this->add(new Hidden("ID_Database"));
        }

        $SearchDatabase = new Text("SearchDatabase");
        $SearchDatabase->setLabel("SEARCH DATABASE NAME");
        $SearchDatabase->setFilters(['striptags', 'string']);
        $SearchDatabase->addValidators([
            new PresenceOf([
                'message' => 'Search database is required.'
            ])
        ]);
        $this->add($SearchDatabase);
                     
    }
}
