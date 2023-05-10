<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Transitionvar extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Transvar;

	/**
	 * @var string
	 */
	public $TransvarName;

	/**
	 * @var string
	 */
	public $TransvarDescription;
	
		
	/** Products initializer
	 */
	public function initialize()
	{
	     $this->hasMany('ID_Transvar', 'transitionvarkeywordtv', 'ID_transvar', [
        	'foreignKey' => [
        		'message' => 'City cannot be deleted because it\'s used in ransition variable - keyword trans. var.'
        	]
      	     ]); 
/**
             $this->hasMany('ID_Transvar', 'Transitionvarculturaldomain', 'ID_Transvar', [
        	'foreignKey' => [
        		'message' => 'Transitional varaible cannot be deleted because it\'s used in Cultural domain'
        	]
             ]);  */
	     $this->hasMany('ID_Transvar', 'Transitionvarsocialimpact', 'ID_Transvar', [
        	'foreignKey' => [
        		'message' => 'Transitional varaible cannot be deleted because it\'s used in Social impact'
        	]
             ]);  
             
        }

	/**
	 * Returns a human representation of 'active'
	 *
	 * @return string
	 */
	public function getActiveDetail()
	{
		if ($this->active == 'Y') {
			return 'Yes';
		}
		return 'No';
	}
}