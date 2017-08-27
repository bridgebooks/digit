<?php 

namespace App\Traits;

use JWTAuth;

trait UserRequest
{
	 public function requestUser() {
    	return JWTAuth::parseToken()->authenticate();
    }

    public function userHasRole(string $name) {
    	
    	$payload = JWTAuth::parseToken()->getPayload();
    	$roles = $payload->get('acl');

    	foreach ($roles as $role) {
    		if($role['name'] == $name) return true;
    		return false;
    	}
    }

    public function belongsToOrg(string $id) {

        $payload = JWTAuth::parseToken()->getPayload();
        $orgs = $payload->get('orgs');

        foreach ($orgs as $org) {
            if($org['id'] == $id) return true;
            return false;
        }
    }

    public function isOwner(string $id) {
	     $user = JWTAuth::parseToken()->authenticate();

	     return $user->id === $id;
    }

    public function getUserRoles() {

        $payload = JWTAuth::parseToken()->getPayload();
        return $payload->get('acl');
    }

    public function getUserOrgs() {
        
        $payload = JWTAuth::parseToken()->getPayload();
        
        if (!$payload->get('orgs')) return [];

        return $payload->get('orgs');
    }


}