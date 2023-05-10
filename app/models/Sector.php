<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Sector extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Sector;

	/**
	 * @var string
	 */
	public $SectorName;
	
		
	/** Products initializer
	 */
	public function initialize()
	{

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