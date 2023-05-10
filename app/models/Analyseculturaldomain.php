<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Analyseculturaldomain extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Analyse;

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
            	$this->belongsTo('ID_Analyse', 'Analyse', 'ID_Analyse', [
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