<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Language extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Language;

	/**
	 * @var string
	 */
	public $Language;
		
	/** Products initializer
	 */
	public function initialize()
	{
            $this->hasMany('ID_Language', 'Document', 'ID_Language', [
          	'foreignKey' => [
        		'message' => 'Language cannot be deleted because it\'s used in Document'
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