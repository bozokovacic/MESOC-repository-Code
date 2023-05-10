<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Relevance extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Relevance;

	/**
	 * @var string
	 */
	public $Relevance;
	
		
	/** Products initializer
	 */
	public function initialize()
	{
      $this->hasMany('ID_Relevance', 'Docrelevance', 'ID_Relevance', [
          	'foreignKey' => [
        		'message' => 'Relevance cannot be deleted because it\'s used in Document'
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