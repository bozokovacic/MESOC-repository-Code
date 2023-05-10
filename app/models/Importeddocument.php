<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Importeddocument extends Model
{
	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var string
	 */
	public $uuid;
        
        /**
	 * @var string
	 */
	public $ID_Document;
        
        /**
	 * @var string
	 */
	public $ID_Waitingroom;
	
        /**
	 * @var string
	 */
	public $file;
        

	/** Products initializer
	 */
	public function initialize()
	{
/**	    $this->belongsTo('ID_Country', 'Country', 'ID_Country', [
			'reusable' => true
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