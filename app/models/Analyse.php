<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Analyse extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Analyse;

	/**
	 * @var string
	 */
	public $AnalyseName;

      	/**
	 * @var string
	 */
	public $AnalyseDescription;
        
        /**
	 * @var string
	 */
	public $Analysecultdomainview;
        
        /**
	 * @var string
	 */
	public $Analysesocimpactview;
        
        /**
	 * @var string
	 */
	public $Analyseview;
               
        /** Products initializer
	 */
	public function initialize()
	{
                 $this->hasMany('ID_Analyse', 'Analyseculturaldomain', 'ID_Analyse', [
        	'foreignKey' => [
        		'message' => 'Analyse cannot be deleted because it\'s used in Research'
        	]
              ]);
               $this->hasMany('ID_Analyse', 'Analysesocialimpact', 'ID_Analyse', [
        	'foreignKey' => [
        		'message' => 'Analyse cannot be deleted because it\'s used in Research'
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