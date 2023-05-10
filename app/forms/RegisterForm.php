<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class RegisterForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        // Name
        $name = new Text('name');
        $name->setLabel('Name and Surname');
        $name->setFilters(['striptags', 'string']);
        $name->addValidators([
            new PresenceOf([
                'message' => 'Name and surname are mandatory'
            ])
        ]);
        $this->add($name);

        // Name
        $name = new Text('username');
        $name->setLabel('User Name');
        $name->setFilters(['alpha']);
        $name->addValidators([
            new PresenceOf([
                'message' => 'Enter user name.'
            ])
        ]);
        $this->add($name);

        // Email
        $email = new Text('email');
        $email->setLabel('Email');
        $email->setFilters('email');
        $email->addValidators([
            new PresenceOf([
                'message' => 'Email is mandatory.'
            ]),
            new Email([
                'message' => 'Email  is incorrect.'
            ])
        ]);
        $this->add($email);

        // Password
        $password = new Password('password');
        $password->setLabel('Password');
        $password->addValidators([
            new PresenceOf([
                'message' => 'Password is mandatory.'
            ])
        ]);
        $this->add($password);

        // Confirm Password
        $repeatPassword = new Password('repeatPassword');
        $repeatPassword->setLabel('Repeat password');
        $repeatPassword->addValidators([
            new PresenceOf([
                'message' => 'Repeat password is mandatory.'
            ])
        ]);
        $this->add($repeatPassword);
           
        $type = new Select('ID_Role', Role::find(), [
            'using'      => ['ID_Role', 'RoleName'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $type->setLabel('Role');
        
        $this->add($type);  
        
        $type = new Select('ID_Partner', Partner::find(), [
            'using'      => ['ID_Partner', 'PartnerName'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
       
        $type->setLabel('Partner');
        
        $this->add($type);  
        
            $type = new Select('ID_Organisation', Organisation::find(), [
            'using'      => ['ID_Organisation', 'OrgName'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
                
        $type->setLabel('Organisation');
        
        $this->add($type);  
    }
}
