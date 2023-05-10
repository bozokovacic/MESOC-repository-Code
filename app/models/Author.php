<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Author extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Author;

	/**
	 * @var string
	 */
	public $FirstName;
        
        /**
	 * @var string
	 */
	public $LastName;
        
        /**
	 * @var string
	 */
	public $MiddleNameInitial;
			
	/** Products initializer
	 */
	public function initialize()
	{
            $this->hasMany('ID_Author', 'Docauthor', 'ID_Author', [
          	'foreignKey' => [
        		'message' => 'Author cannot be deleted because it\'s used in Document'
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