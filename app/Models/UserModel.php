<?php
/**
 * 	@author: $rachow
 * 	@copyright: CF Partners 2023
 *
 * 	Users ORM
*/

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    	protected $DBGroup          = 'default';
    	protected $table            = 'cf_users';
    	protected $primaryKey       = 'id';
    	protected $useAutoIncrement = true;
    	protected $returnType       = 'array';
    	protected $useSoftDeletes   = false;
    	protected $protectFields    = true;
    	protected $allowedFields    = [
		    'title',
		    'firstname',
		    'lastname',
		    'mobile',
		    'email',
		    'username',
		    'password'
	    ];
	
	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];

	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	/**
	public function username_exists($username): bool
	{
		$this->db->where('username', $username);
		$query = $this->db->get('cf_users');
		return ( $query->num_rows() > 0 ) ? true : false;	
	}
	*/
}

