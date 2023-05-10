<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class City extends Model
{
	/**
	 * @var integer
	 */
	public $ID_City;

	/**
	 * @var string
	 */
	public $CityCode;
        
        /**
	 * @var string
	 */
	public $CityName;
	
        /**
	 * @var string
	 */
	public $ID_Country;
        
        /**
	 * @var string
	 */
	public $CityTeritCon;

	/**
	 * @var string
	 */
	public $LATITUDE;

	/**
	 * @var string
	 */
	public $LONGITUDE;
		
	/** Products initializer
	 */
	public function initialize()
	{
	    $this->belongsTo('ID_Country', 'Country', 'ID_Country', [
			'reusable' => true
		]);

	    $this->hasMany('ID_City', 'Organisation', 'ID_City', [
        	'foreignKey' => [
        		'message' => 'City cannot be deleted because it\'s used in Organisation'
        	]
             ]);
             $this->hasMany('ID_City', 'Doccountry', 'ID_City', [
        	'foreignKey' => [
        		'message' => 'City cannot be deleted because it\'s used in Research'
        	]
             ]);
             $this->hasMany('ID_City', 'Doccity', 'ID_City', [
        	'foreignKey' => [
        		'message' => 'City cannot be deleted because it\'s used in Document - city'
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