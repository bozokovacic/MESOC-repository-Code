<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Organisation extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Organisation;

	/**
	 * @var string
	 */
	public $OrgName;
        
        /**
	 * @var string
	 */
	public $OrgAdress;
        
        /**
         * @var string
	 */
	public $ID_City;
        
        /**
         * @var string
	 */
	public $ID_Country;

		
	/** Products initializer
	 */
	public function initialize()
	{
            {
		$this->belongsTo('ID_City', 'City', 'ID_City', [
			'reusable' => true
		]);
            }
            
            {
		$this->belongsTo('ID_Country', 'Country', 'ID_Country', [
			'reusable' => true
		]);
                                
            }
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