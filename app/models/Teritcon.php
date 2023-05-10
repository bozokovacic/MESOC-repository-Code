<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Teritcon extends Model
{
	/**
	 * @var integer
	 */
	public $ID_TeritCon;

	/**
	 * @var string
	 */
	public $TeritCon;
		
	/** Products initializer
	 */
	public function initialize()
	{
 /**            $this->hasMany('ID_Region', 'Doccountry', 'ID_Region', [
        	'foreignKey' => [
        		'message' => 'Region cannot be deleted because it\'s used in Research'
        	]
              ]);  */
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