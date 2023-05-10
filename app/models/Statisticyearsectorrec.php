<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Statisticyearsectorrec extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Statisticyearsector;

	/**
	 * @var string
	 */
	public $Year;

      	/**
	 * @var string
	 */
        public $Sector1;
        
        /**
            * @var string
	 */
         public $Sector2;
                           
        /**
	 * @var string
	 */
        public $Sector3;
        
        /**
	** @var string
	 */
        public $Sector4;

	/**
	** @var string
	 */
        public $Cell;
                
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