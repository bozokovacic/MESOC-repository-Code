<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Analysesocialimpact extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Analyse;

	/**
	 * @var string
	 */
	public $ID_SocImpact;
      	        
        /** Products initializer
	 */
	public function initialize()
	{
            {
            	$this->belongsTo('ID_SocImpact', 'Socialimpact', 'ID_SocIMpact', [
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