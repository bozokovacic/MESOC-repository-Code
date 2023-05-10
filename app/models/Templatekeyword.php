<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Templatekeyword extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Proposal;

	/**
	 * @var string
	 */
	public $ID_ProposalKeyword;
        
        /**
	 * @var string
	 */
	public $Keyword;
        
        /**
	 * @var string
	 */
	public $ID_Keyword;
      	        
        /** Products initializer
	 */
	public function initialize()
	{
               {
            	$this->belongsTo('ID_Keyword', 'Keyword', 'ID_Keyword', [
			'reusable' => true
		]);
            }  
            {
            	$this->belongsTo('ID_Template', 'Template', 'ID_Template', [
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