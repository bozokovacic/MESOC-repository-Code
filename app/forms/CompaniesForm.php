<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class CompaniesForm extends Form
{
    /**
     * Initialize the companies form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("id");
            $this->add($element->setLabel("Šifra"));
        } else {
            $this->add(new Hidden("id"));
        }

        $naziv = new Text("naziv");
        $naziv->setLabel("Naziv");
        $naziv->setFilters(['striptags', 'string']);
        $naziv->addValidators([
            new PresenceOf([
                'message' => 'Name is required'
            ])
        ]);
        $this->add($naziv);

        $ulica = new Text("ulica");
        $ulica->setLabel("Adresa");
        $ulica->setFilters(['striptags', 'string']);
        $ulica->addValidators([
            new PresenceOf([
                'message' => 'Address is required'
            ])
        ]);
        $this->add($ulica);

        $mjesto = new Text("mjesto");
        $mjesto->setLabel("Mjesto");
        $mjesto->setFilters(['striptags', 'string']);
        $mjesto->addValidators([
            new PresenceOf([
                'message' => 'City is required'
            ])
        ]);
        $this->add($mjesto);
		
		$ppt = new Text("ppt");
        $ppt->setLabel("PPT");
        $ppt->setFilters(['striptags', 'string']);
        $ppt->addValidators([
            new PresenceOf([
                'message' => 'City is required'
            ])
        ]);
        $this->add($ppt);
		
		$tel = new Text("tel");
        $tel->setLabel("Telefon");
        $tel->setFilters(['striptags', 'string']);
        $tel->addValidators([
            new PresenceOf([
                'message' => 'Telephone is required'
            ])
        ]);
        $this->add($tel);
		
		$prezime = new Text("prezime");
        $prezime->setLabel("Prezime");
        $prezime->setFilters(['striptags', 'string']);
        $prezime->addValidators([
            new PresenceOf([
                'message' => 'Telephone is required'
            ])
        ]);
        $this->add($prezime);
		
		$ime = new Text("ime");
        $ime->setLabel("Ime");
        $ime->setFilters(['striptags', 'string']);
        $ime->addValidators([
            new PresenceOf([
                'message' => 'Telephone is required'
            ])
        ]);
        $this->add($ime);
		
		$umjetickoime = new Text("umjetickoime");
        $umjetickoime->setLabel("Umjetničko ime");
        $umjetickoime->setFilters(['striptags', 'string']);
        $umjetickoime->addValidators([
            new PresenceOf([
                'message' => 'Telephone is required'
            ])
        ]);
        $this->add($umjetickoime);
    }
}
