<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Region extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Region;

	/**
	 * @var string
	 */
	public $RegionName;

      	/**
	 * @var string
	 */
	public $RegionTeritCon;
        
        /**
	 * @var string
	 */
	public $ID_Country;
        
        /**
	 * @var string
	 */
	public $NUTSType;
        
        /** Products initializer
	 */
	public function initialize()
	{
             $this->hasMany('ID_Region', 'Doccountry', 'ID_Region', [
        	'foreignKey' => [
        		'message' => 'Region cannot be deleted because it\'s used in Research'
        	]
              ]);
            {
            	$this->belongsTo('ID_Country', 'Country', 'ID_Country', [
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