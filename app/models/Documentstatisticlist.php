<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Documentstatisticlist extends Model
{
	/**
	 * @var integer
	*/
    	public $ID_Docstatistic;
    
        /**
	 * @var integer
	 */
	public $ID_Doc;

	
	/** Products initializer
	 */
	public function initialize()
	{
/**	    $this->belongsTo('ID_Doc', 'Document', 'ID_Doc', [
			'reusable' => true
		]);   */         
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