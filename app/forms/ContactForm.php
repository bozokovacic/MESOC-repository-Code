<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class ContactForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        // Name
        $name = new Text('name');
        $name->setLabel('Name and Surname');
        $name->setFilters(['striptags', 'string']);
        $name->addValidators([
            new PresenceOf([
                'message' => 'Name and surname are requried.'
            ])
        ]);
        $this->add($name);

        // Email
        $email = new Text('email');
        $email->setLabel('Email');
        $email->setFilters('email');
        $email->addValidators([
            new PresenceOf([
                'message' => 'Email is required.'
            ]),
            new Email([
                'message' => 'Email is incorrect'
            ])
        ]);
        $this->add($email);

        $comments = new TextArea('comments');
        $comments->setLabel('Coments');
        $comments->setFilters(['striptags', 'string']);
        $comments->addValidators([
            new PresenceOf([
                'message' => 'Coment is required'
            ])
        ]);
        $this->add($comments);
    }
}
