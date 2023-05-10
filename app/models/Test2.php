<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Test2 extends Model
{
/**
	 * @var integer
	 */
	public $ID_Country;

	/**
	 * @var string
	 */
	public $CountryCode;

      	/**
	 * @var string
	 */
	public $CountryName;
             
	/** Products initializer
	 */
	public function initialize()
	{
/**            $this->hasMany('ID_Country', 'Docauthor', 'ID_Country', [
        	'foreignKey' => [
        		'message' => 'Country cannot be deleted because it\'s used in Document-Author'
        	]
              ]); 
            $this->hasMany('ID_Country', 'Institution', 'ID_Country', [
        	'foreignKey' => [
        		'message' => 'Country cannot be deleted because it\'s used in Instituiton'
        	]
              ]); 
            $this->hasMany('ID_Country', 'Doccountry', 'ID_Country', [
        	'foreignKey' => [
        		'message' => 'Country cannot be deleted because it\'s used in Document-Country'
        	]
             ]);
                $this->hasMany('ID_Country', 'City', 'ID_Country', [
        	'foreignKey' => [
        		'message' => 'Country cannot be deleted because it\'s used in City'
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