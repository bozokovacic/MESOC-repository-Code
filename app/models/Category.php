<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Category extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Category;

	/**
	 * @var string
	 */
	public $CategoryName;
        
        /**
	 * @var string
	 */
	public $CategoryDescription;
	
		
	/** Products initializer
	 */
	public function initialize()
	{
	    $this->hasMany('ID_Category', 'Document', 'ID_Category', [
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