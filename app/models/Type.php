<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Type extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Type;

	/**
	 * @var string
	 */
	public $DocType;
	
		
	/** Products initializer
	 */
	public function initialize()
	{
	    $this->hasMany('ID_Type', 'Document', 'ID_Type', [
          	'foreignKey' => [
        		'message' => 'Type cannot be deleted because it\'s used in Document'
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