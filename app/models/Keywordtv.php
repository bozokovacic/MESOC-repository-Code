<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Keywordtv extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Keywordtv;

	/**
	 * @var string
	 */
	public $KeywordtvName;

      	/**
	 * @var string
	 */
	public $KeywordtvDescription;

      	/**
	 * @var string
	 */
	public $Keywordtvcultdomainview;
        
      	/**
	 * @var string
	 */
	public $Cultdomainview;
        
      	/**
	 * @var string
	 */
	public $Keywordtvsocimpactview;
        
      	/**
	 * @var string
	 */
	public $Socimpactview;

		
	/** Products initia lizer
	 */
	public function initialize()
	{
/**              $this->hasMany('ID_Keywordtv', 'Keywordtvculturaldomain', 'ID_Keywordtv', [
        	'foreignKey' => [
        		'message' => 'Keyword transitional varaible cannot be deleted because it\'s used in Cultural domain'
        	]
             ]);  
	     $this->hasMany('ID_Keywordtv', 'Keywordtvsocialimpact', 'ID_Keywordtv', [
        	'foreignKey' => [
        		'message' => 'Keyword transitional varaible cannot be deleted because it\'s used in Social impact'
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