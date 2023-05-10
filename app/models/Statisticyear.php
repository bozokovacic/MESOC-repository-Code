<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Statisticyear extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Statisticyear;

	/**
	 * @var string
	 */
	public $Year;

      	/**
	 * @var string
	 */
        public $ID_CultDomain;
        
        /**
            * @var string
	 */
         public $Yeardomain;/**
                  
        /**
	 * @var string
	 */
        public $ID_SocImpact;/**
	
	 * @var string
	 */
        public $Yearsector;
        
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