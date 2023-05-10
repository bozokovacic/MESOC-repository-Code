<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Partner extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Partner;
        
        /**
	 * @var integer
	 */
	public $ID_Number;

	/**
	 * @var string
	 */
	public $PartnerName;
        
        /**
	 * @var string
	 */
	public $PartnerAcr;
		
	/** Products initializer
	 */
	public function initialize()
	{
                $this->hasMany('ID_Partner', 'Users', 'ID_Partner', [
        	'foreignKey' => [
        		'message' => 'Partner cannot be deleted because it\'s used in Users'
        	]
              ]);  
                $this->hasMany('ID_Partner', 'Template', 'ID_Partner', [
        	'foreignKey' => [
        		'message' => 'Partner cannot be deleted because it\'s used in Users'
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