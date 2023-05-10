<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Keywordtvsocialimpact extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Keywordtv;

	/**
	 * @var string
	 */
	public $ID_SocImpact;
      	        
        /** Products initializer
	 */
	public function initialize()
	{
/**            {
            	$this->belongsTo('ID_SocImpact', 'Socialimpact', 'ID_SocImpact', [
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