<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;

class Users extends Model
{
         
    public function validation()
    {
        $validator = new Validation();
        
        $validator->add(
            'email',
            new EmailValidator([
            'message' => 'Invalid email.'
        ]));
        $validator->add(
            'email',
            new UniquenessValidator([
            'message' => 'The email was assigned to an existing user.'
        ]));
        $validator->add(
            'username',
            new UniquenessValidator([
            'message' => 'The username has already been assigned to the user.'
        ]));
        
        return $this->validate($validator);
    }
    
    public function initialize()
	{
            {
            	$this->belongsTo('ID_Role', 'Role', 'ID_Role', [
			'reusable' => true
		]);
            }
            {
            	$this->belongsTo('ID_Partner', 'Partner', 'ID_Partner', [
			'reusable' => true
		]);  
            } 
        }
}
