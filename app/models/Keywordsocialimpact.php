<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Keywordsocialimpact extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Keyword;

	/**
	 * @var string
	 */
	public $ID_SocImpact;
      	        
        /** Products initializer
	 */
	public function initialize()
	{
            {
            	$this->belongsTo('ID_SocImpact', 'Socialimpact', 'ID_SocImpact', [
			'reusable' => true
		]);
            }
            {
            	$this->belongsTo('ID_Keyword', 'Keyword', 'ID_Keyword', [
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