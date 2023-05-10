<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Statisticyeardomainrec extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Statisticyeardomain;

	/**
	 * @var string
	 */
	public $Year;

      	/**
	 * @var string
	 */
        public $Domain1;
        
        /**
            * @var string
	 */
         public $Domain2;
                           
        /**
	 * @var string
	 */
        public $Domain3;
        
        /**
	** @var string
	 */
        public $Domain4;
        
        /**
	 * @var string
	 */
        public $Domain5;
        
        /**
	 * @var string
	 */
        public $Domain6;
        
        /**
            * @var string
	 */
         public $Domain7;
                           
        /**
	 * @var string
	 */
        public $Domain8;
        
        /**
	 * @var string
	 */
        public $Domain9;
        
        /**
	 * @var string
	 */
        public $Domain10;
        
        /**
	 * @var string
	 */
        public $Domain11;

	/**
	 * @var string
	 */
        public $Cells;
        
        /**
	* * @var string
	 */
        public $Total;
        
        
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