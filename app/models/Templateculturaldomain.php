<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Templateculturaldomain extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Proposal;

	/**
	 * @var string
	 */
	public $ID_CultDomain;
      	        
        /** Products initializer
	 */
	public function initialize()
	{
            {
            	$this->belongsTo('ID_CultDomain', 'Culturaldomain', 'ID_CultDomain', [
			'reusable' => true
		]);
            }
            {
            	$this->belongsTo('ID_Proposal', 'Template', 'ID_Proposal', [
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