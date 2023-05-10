<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Keyword extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Keyword;

	/**
	 * @var string
	 */
	public $KeywordName;

      	/**
	 * @var string
	 */
	public $KeywordDescription;

      	/**
	 * @var string
	 */
	public $Keywordcultdomainview;
        
      	/**
	 * @var string
	 */
	public $Cultdomainview;
        
      	/**
	 * @var string
	 */
	public $Keywordsocimpactview;
        
      	/**
	 * @var string
	 */
	public $Socimpactview;

		
	/** Products initia lizer
	 */
	public function initialize()
	{
              $this->hasMany('ID_Keyword', 'Keywordculturaldomain', 'ID_Keyword', [
        	'foreignKey' => [
        		'message' => 'Keyword cannot be deleted because it\'s used in Cultural domain'
        	]
             ]);  
	     $this->hasMany('ID_Keyword', 'Keywordsocialimpact', 'ID_Keyword', [
        	'foreignKey' => [
        		'message' => 'Keyword cannot be deleted because it\'s used in Social impact'
        	]
             ]);  
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