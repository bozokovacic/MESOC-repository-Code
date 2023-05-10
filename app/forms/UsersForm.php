<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class UsersForm extends Form
{
    /**
     * Initialize the User form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("id");
            $this->add($element->setLabel("User ID"));
        } else {
            $this->add(new Hidden("id"));
        }

        $username = new Text("userName");
        $username->setLabel("User name");
        $username->setFilters(['striptags', 'string']);
        $username->addValidators([
            new PresenceOf([
                'message' => 'User name is required.'
            ])
        ]);
        $this->add($username);
  	       
        $password = new Password("password");
        $password->setLabel("Password");
        $password->setFilters(['striptags', 'string']);
        $UserName->addValidators([
            new PresenceOf([
                'message' => 'password is required.'
            ])
        ]);
        $this->add($password);
        
        $name = new Text("name");
        $name->setLabel("Name and Surname");
        $name->setFilters(['striptags', 'string']);
        $name->addValidators([
            new PresenceOf([
                'message' => 'Name and ID_Role name is required.'
            ])
        ]);
        $this->add($name);
         
        $email = new Text("email");
        $email->setLabel("Email");
        $email->setFilters(['striptags', 'string']);
        $email->addValidators([
            new PresenceOf([
                'message' => 'Email is required.'
            ])
        ]);
        $this->add($email);

        $ID_Role = new Text("ID_Role");
        $ID_Role->setLabel("Role");
        $ID_Role->setFilters(['striptags', 'string']);
        $ID_Role->addValidators([
            new PresenceOf([
                'message' => 'Role is required.'
            ])
        ]);
        $this->add($ID_Role);        
        
        $ID_Role = new Text("ID_Parner");
        $ID_Role->setLabel("Partner");
        $ID_Role->setFilters(['striptags', 'string']);
        $ID_Role->addValidators([
            new PresenceOf([
                'message' => 'Partner is required.'
            ])
        ]);     
        
        }
}
