<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Statistic extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Statistic;

	/**
	 * @var string
	 */
	public $Row;

      	/**
	 * @var string
	 */
        public $ID_Domain;
        
        /**
	 * @var string
	 */
        public $CultDomainName;

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
	 * @var string
	 */
	public $General;

        /**
	 * @var string
	 */
	public $Cells;

        /**
	 * @var string
	 */
	public $Total;


        /**
	 * @var string
	 */
	public $CultDomains;
                      
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