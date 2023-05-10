<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Culturaldomain extends Model
{
	/**
	 * @var integer
	 */
	public $ID_CultDomain;

	/**
	 * @var string
	 */
	public $CultDomainName;
        
        /**
	 * @var string
	 */
	public $CultDomainDescription;
	
		
	/** Products initializer
	 */
	public function initialize()
	{
/**            $this->hasMany('ID_Sector', 'Document', 'ID_Doc', [
        	'foreignKey' => [
        		'message' => 'Product Type cannot be deleted because it\'s used in Products'
        	]
             ]); */
            
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