<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Doccountry extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Research;
        
        /**
	 * @var integer
	 */
	public $ID_Doc;

	/**
	 * @var string
	 */
	public $ID_Country;
        
        /**
	 * @var string
	 */
	public $ID_City;
        
        /**
         * @var string
	 */
	public $ID_Region;

        /**
         * @var string
	 */
	public $TeritCon;

		
	/** Products initializer
	 */
	public function initialize()
	{
            {
            	$this->belongsTo('ID_Doc', 'Document', 'ID_Doc', [
			'reusable' => true
		]);
            }
            {
            	$this->belongsTo('ID_City', 'City', 'ID_City', [
			'reusable' => true
		]);
            }
            {
            	$this->belongsTo('ID_Region', 'Region', 'ID_Region', [
			'reusable' => true
		]);
            }
            {
            	$this->belongsTo('ID_Country', 'Country', 'ID_Country', [
			'reusable' => true
		]);
            }
                {
/**            	$this->belongsTo('ID_TeritCon', 'Teritcon', 'ID_TeritCon', [
			'reusable' => true
		]);  */
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