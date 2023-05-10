<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Analysekeyword extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Analyse;

	/**
	 * @var string
	 */
	public $ID_Keyword;    	        
               
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