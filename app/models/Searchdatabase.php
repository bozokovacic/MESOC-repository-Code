<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Searchdatabase extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Database;

	/**
	 * @var string
	 */
	public $SearchDatabase;
	
		
	/** Products initializer
	 */
	public function initialize()
	{
            $this->hasMany('ID_Database', 'Docsearchdatabase', 'ID_Database', [
          	'foreignKey' => [
        		'message' => 'Search database cannot be deleted because it\'s used in Document'
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