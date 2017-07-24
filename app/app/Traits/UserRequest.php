<?php 

namespace App\Traits;

use JWTAuth;

trait UserRequest
{
	 public function requestUser() {
    	return JWTAuth::parseToken()->authenticate();
    }

    public function userHasRole(String $name) {
    	
    	$payload = JWTAuth::parseToken()->getPayload();
    	$roles = $payload->get('acl');

    	foreach ($roles as $role) {
    		if($role['name'] == $name) return true;
    		return false;
    	}
    }
}