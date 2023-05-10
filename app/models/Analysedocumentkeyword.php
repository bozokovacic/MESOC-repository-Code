<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Analysedocumentkeyword extends Model
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
	public $ID_Keyword;    	        
               
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
	public $Keywordview;    	        
        
        /**
	 * @var string
	 */
	public $Abstractview;    	        
        
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
/**            {
            	$this->belongsTo('ID_Analyse', 'Analysedocument', 'ID_Analyse',[ 
                			'reusable' => true]) AND    
                $this->belongsTo('ID_Doc', 'AnalyseDocument', 'ID_Doc', [
			'reusable' => true]); 
            }  */
                {
            	$this->belongsTo('ID_Doc', 'Document', 'ID_Doc', [
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