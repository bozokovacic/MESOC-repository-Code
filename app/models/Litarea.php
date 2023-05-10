<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Litarea extends Model
{
	/**
	 * @var integer
	 */
	public $ID_LitArea;

	/**
	 * @var string
	 */
	public $LiteratureArea;
	
		
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