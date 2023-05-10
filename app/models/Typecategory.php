<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Typecategory extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Type;

	/**
	 * @var string
	 */
	public $ID_Category;
        
        /**
	 * @var string
	 */
	public $DocType;
        
        /** Products initializer
	 */
	public function initialize()
	{
            {
            	$this->belongsTo('ID_type', 'Type', 'ID_Type', [
			'reusable' => true
		]);
            }
            {
            	$this->belongsTo('ID_Category', 'Category', 'ID_Category', [
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