<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Analysedocument extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Analyse;

	/**
	 * @var string
	 */
	public $ID_Doc;    	        
                    
        /**
	 * @var string
	 */
	public $ID_KeywordCount;    	        
        
        /**
	 * @var string
	 */
	public $ID_AbstractCount;    	        
        
        /**
	 * @var string
	 */
	public $ID_Keywordview;    	        
        
        /**
	 * @var string
	 */
	public $ID_Abstractview;    	        
        
        /** Products initializer
	 */
	public function initialize()
	{
/**                 $this->hasMany('ID_Analyse', 'Analyseculturaldomain', 'ID_Analyse', [
        	'foreignKey' => [
        		'message' => 'Analyse cannot be deleted because it\'s used in Research'
        	]
              ]);
               $this->hasMany('ID_Analyse', 'Analysesocialimpact', 'ID_Analyse', [
        	'foreignKey' => [
        		'message' => 'Analyse cannot be deleted because it\'s used in Research'
        	]
              ]);  */
               {
            	$this->belongsTo('ID_Analyse', 'Analyse', 'ID_Analyse', [
			'reusable' => true
		]);
            }
                {
            	$this->belongsTo('ID_Doc', 'Document', 'ID_Doc', [
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