<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Doclist extends Model
{
	/**
	 * @var integer
	*/
    	public $ID_Doclist;
    
        /**
	 * @var integer
	 */
	public $ID_Doc;
       
        /**
	 * @var string
	 */
	public $Domains;

        /**
	 * @var string
	 */
	public $Sectors;
                		
	/** Products initializer
	 */
	public function initialize()
	{
	    $this->belongsTo('ID_Doc', 'Document', 'ID_Doc', [
			'reusable' => true
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