<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Beneficiary extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Beneficiary;

	/**
	 * @var string
	 */
	public $BeneficiaryName;
	
		
	/** Products initializer
	 */
	public function initialize()
	{
            $this->hasMany('ID_Beneficiary', 'DocBeneficiary', 'ID_Beneficiary', [
        	'foreignKey' => [
        		'message' => 'Beneficiary cannot be deleted because it\'s used in Document'
        	]  
             ]);  
            
	    /** $this->belongsTo('sifrasvojstva', 'Svojstva', 'sifra', [
			'reusable' => true
		]);
		$this->belongsTo('sifrasuradnika', 'Suradnici', 'sifrasurdn', [
			'reusable' => true
		]); */
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