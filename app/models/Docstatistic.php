<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Docstatistic extends Model
{
	/**
	 * @var integer
	*/
    	public $ID_Docstatistic;
    
        /**
	 * @var integer
	 */
	public $ID_Doc;

	/**
	 * @var string
	 */
	public $ID_CultDomain;
        
        /**
	 * @var string
	 */
	public $Domains;
	
        /**
	 * @var string
	 */
	public $ID_SocImpact;
	
        /**
	 * @var string
	 */
	public $Sectors;

	/**
	 * @var string
	 */
	public $ID_Category;
                		
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