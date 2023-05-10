<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Dataprov extends Model
{
	/**
	 * @var integer
	 */
	public $ID_DataProv;

	/**
	 * @var string
	 */
	public $DataProvName;
		
	/** Products initializer
	 */
	public function initialize()
	{
             $this->hasMany('ID_DataProv', 'Docdataprov', 'ID_DataProv', [
        	'foreignKey' => [
        		'message' => 'Region cannot be deleted because it\'s used in Research'
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