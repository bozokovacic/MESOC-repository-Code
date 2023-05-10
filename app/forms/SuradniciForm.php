<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class SuradniciForm extends Form
{
    /**
     * Initialize the companies form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("SIFRASURDN");
            $this->add($element->setLabel("Šifra"));
        } else {
            $this->add(new Hidden("SIFRASURDN"));
        }

        $NAZIV = new Text("NAZIV");
        $NAZIV->setLabel("Naziv");
        $NAZIV->setFilters(['striptags', 'string']);
        $NAZIV->addValidators([
            new PresenceOf([
                'message' => 'Naziv je potreban.'
            ])
        ]);
        $this->add($NAZIV);

        $ULICA = new Text("ULICA");
        $ULICA->setLabel("Adresa");
        $ULICA->setFilters(['striptags', 'string']);
        $ULICA->addValidators([
            new PresenceOf([
                'message' => 'Adresa je potrebna.'
            ])
        ]);
        $this->add($ULICA);

        $MJESTO = new Text("MJESTO");
        $MJESTO->setLabel("Mjesto");
        $MJESTO->setFilters(['striptags', 'string']);
        $MJESTO->addValidators([
            new PresenceOf([
                'message' => 'Mjesto je potrebno.'
            ])
        ]);
        $this->add($MJESTO);
		
		$PTT = new Text("PTT");
        $PTT->setLabel("PTT");
        $PTT->setFilters(['striptags', 'string']);
        $PTT->addValidators([
            new PresenceOf([
                'message' => 'City is required'
            ])
        ]);
        $this->add($PTT);
		
		$TEL = new Text("TEL");
        $TEL->setLabel("Telefon");
        $TEL->setFilters(['striptags', 'string']);
        $TEL->addValidators([
            new PresenceOf([
                'message' => 'Telephone is required'
            ])
        ]);
        $this->add($TEL);
		
		$PREZIME = new Text("PREZIME");
        $PREZIME->setLabel("Prezime");
        $PREZIME->setFilters(['striptags', 'string']);
        $PREZIME->addValidators([
            new PresenceOf([
                'message' => 'Telephone is required'
            ])
        ]);
        $this->add($PREZIME);
		
		$IME = new Text("IME");
        $IME->setLabel("Ime");
        $IME->setFilters(['striptags', 'string']);
        $IME->addValidators([
            new PresenceOf([
                'message' => 'Telephone is required'
            ])
        ]);
        $this->add($IME);
		
		$UMJTICKOIME = new Text("UMJTICKOIME");
        $UMJTICKOIME->setLabel("Umjetničko IME");
        $UMJTICKOIME->setFilters(['striptags', 'string']);
        $UMJTICKOIME->addValidators([
            new PresenceOf([
                'message' => 'Umjetničko ime je potrebno.'
            ])
        ]);
        $this->add($UMJTICKOIME);
    }
}
