<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Technique extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Technique;

	/**
	 * @var string
	 */
	public $TechniqueName;
	
		
	/** Products initializer
	 */
	public function initialize()
	{
	  $this->hasMany('ID_Technique', 'Doctechnique', 'ID_Technique', [
          	'foreignKey' => [
        		'message' => 'Technique cannot be deleted because it\'s used in Document'
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