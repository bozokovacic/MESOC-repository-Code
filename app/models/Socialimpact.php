<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Socialimpact extends Model
{
	/**
	 * @var integer
	 */
	public $ID_SocImpact;

	/**
	 * @var string
	 */
	public $SocImpactName;
        
        /**
	 * @var string
	 */
	public $SocImpactDescription;
	
		
	/** Products initia lizer
	 */
	public function initialize()
	{
/**            $this->hasMany('ID_SocImpact', 'Keywordsocialimpact', 'ID_SocImpact', [
        	'foreignKey' => [
        		'message' => 'Product Type cannot be deleted because it\'s used in Keyword->social impact'
        	]
             ]);  */
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