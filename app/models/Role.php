<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Role extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Role;
        
        /**
	 * @var integer
	 */
	public $RoleNumber;

	/**
	 * @var string
	 */
	public $RoleName;
		
	/** Products initializer
	 */
	public function initialize()
	{
             $this->hasMany('ID_Role', 'Users', 'ID_Role', [
        	'foreignKey' => [
        		'message' => 'Role cannot be deleted because it\'s used in Research'
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