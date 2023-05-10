<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Institution extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Institution;

	/**
	 * @var string
	 */
	public $InstName;
        
        /**
	 * @var string
	 */
	public $InstAdress;
        
        /**
         * @var string
	 */
	public $ID_Country;

		
	/** Products initializer
	 */
	public function initialize()
	{
            {
		$this->belongsTo('ID_Country', 'Country', 'ID_Country', [
			'reusable' => true
		]);
                
                $this->hasMany('ID_Institution', 'Docinstitution', 'ID_Institution', [
          	'foreignKey' => [
        		'message' => 'Institution cannot be deleted because it\'s used in Documents'
        	]
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