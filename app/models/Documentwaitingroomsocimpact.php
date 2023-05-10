<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Documentwaitingroomsocimpact extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Doc;

	/**
	 * @var string
	 */
	public $ID_SocImpact;
      	        
        /** Products initializer
	 */
	public function initialize()
	{
/**            {
            	$this->belongsTo('ID_CultDomain', 'Culturaldomain', 'ID_CultDomain', [
			'reusable' => true
		]);
            }
            {
            	$this->belongsTo('ID_Keywordtv', 'Keywordtv', 'ID_Keywordtv', [
			'reusable' => true
		]);
            }  */
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