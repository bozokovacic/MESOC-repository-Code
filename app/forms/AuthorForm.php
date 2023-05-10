<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class AuthorForm extends Form
{
    /**
     * Initialize the type form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Author");
            $this->add($element->setLabel("AUTHOR ID"));
        } else {
            $this->add(new Hidden("ID_Author"));
        }

        $FirstName = new Text("FirstName");
        $FirstName->setLabel("FIRST NAME");
        $FirstName->setFilters(['striptags', 'string']);
        $FirstName->addValidators([
            new PresenceOf([
                'message' => 'Author firstname is required.'
            ])
        ]);
        
        $this->add($FirstName);
       
    
        $LastName = new Text("LastName");
        $LastName->setLabel("LAST NAME");
        $LastName->setFilters(['striptags', 'string']);
        $LastName->addValidators([
            new PresenceOf([
                'message' => 'Author last tname is required.'
            ])
        ]);
       
        $this->add($LastName);
      
      
        $MiddleNameInitial = new Text("MiddleNameInitial");
        $MiddleNameInitial->setLabel("MIDDLE NAME INITIAL");
        $MiddleNameInitial->setFilters(['striptags', 'string']);
        $MiddleNameInitial->addValidators([
/**            new PresenceOf([
                'message' => 'Author middle name initial is required.'
            ]) */
        ]);
        $this->add($MiddleNameInitial);
        
    }
}
