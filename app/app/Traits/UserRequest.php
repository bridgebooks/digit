<?php 

namespace App\Traits;

use App\Models\User;
use JWTAuth;

trait UserRequest
{
    /**
     * Get requesting user
     * @return App\Models\User;
     */
    public function requestUser(): User {
    	return JWTAuth::parseToken()->authenticate();
    }

    public function userHasRole(string $name) 
    { 	
    	$payload = JWTAuth::parseToken()->getPayload();
    	$roles = $payload->get('roles');

    	foreach ($roles as $role) {
    		if($role['name'] == $name) return true;
    		return false;
    	}
    }

    public function belongsToOrg(string $id) 
    {
        $payload = JWTAuth::parseToken()->getPayload();
        $orgs = $payload->get('orgs');

        foreach ($orgs as $org) {
            if($org['id'] == $id) return true;
            return false;
        }
    }

    public function isOwner(string $id) 
    {
	     $user = JWTAuth::parseToken()->authenticate();

	     return $user->id === $id;
    }

    public function can(string $role)
    {
        $payload = JWTAuth::parseToken()->getPayload();
        $userACL = $payload->get('acl');

        $allow = false;

        $parsedRole = explode('.', $role);
        $group = $parsedRole[0];
        $action = isset($parsedRole[1]) ? $parsedRole[1] : null;

        foreach($userACL as $accessLevel) {
            if ($group && $action) {
                $test = isset($accessLevel['permissions'][$group][$action]) ? $accessLevel['permissions'][$group][$action] : 0;
                $allow = (bool) $test;
            } else {
                $allow = isset($accessLevel['permissions'][$group]) && $accessLevel['permissions'][$group] == 1
                    ? true
                    : false;
            }
        }

        return $allow;
    }

    public function getUserRoles() 
    {
        $payload = JWTAuth::parseToken()->getPayload();
        return $payload->get('roles');
    }

    public function getUserOrgs() 
    {
        $payload = JWTAuth::parseToken()->getPayload();
        
        if (!$payload->get('orgs')) return [];

        return $payload->get('orgs');
    }


}