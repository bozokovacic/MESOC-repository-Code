<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Templatesocialimpact extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Proposal;

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