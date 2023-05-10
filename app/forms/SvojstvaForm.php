<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;

class SvojstvaForm extends Form
{
    /**
     * Initialize the Svojstva form
     */
    public function initialize($entity = null, $options = array())
    {
        if (!isset($options['edit'])) {
            $element = new Text("SIFRA");
            $this->add($element->setLabel("ŠIFRA"));
        } else {
            $this->add(new Hidden("SIFRA"));
        }

        $OPIS = new Text("OPIS");
        $OPIS->setLabel("Opis svojstva");
        $OPIS->setFilters(['striptags', 'string']);
        $OPIS->addValidators([
            new PresenceOf([
                'message' => 'Ime je potrebno'
            ])
        ]);
        $this->add($OPIS);
		
		$OPASKA = new Text("OPASKA");
        $OPASKA->setLabel("Opaska");
        $OPASKA->setFilters(['striptags', 'string']);
        $OPASKA->addValidators([
            new PresenceOf([
                'message' => 'Opis je potreban'
            ])
        ]);
        $this->add($OPASKA);
    }
}
