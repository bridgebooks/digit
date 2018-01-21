<?php

namespace App\Http\Controllers\V1\Orgs;

use Illuminate\Http\Request;
use App\Http\Controllers\V1\Controller;
use App\Http\Controllers\Traits\Pageable;
use App\Repositories\OrgRepository;
use App\Repositories\UserRepository;
use App\Repositories\OrgRoleRepository;
use App\Repositories\RoleRepository;
use App\Presenters\OrgUserPresenter;
use App\Presenters\OrgRolePresenter;
use App\Http\Requests\V1\InviteUser;
use App\Events\UserInvited;

class OrgUserController extends Controller
{
	use Pageable;

	protected $orgRepository;
	protected $orgRoleRepository;
	protected $userRepository;
	protected $roleRepository;

	public function __construct(
		OrgRepository $orgRepository, UserRepository $userRepository, 
		OrgRoleRepository $orgRoleRepository, RoleRepository $roleRepository
	)
	{
		$this->middleware('jwt.auth');
        $this->middleware('subscription.check');
        $this->middleware('acl:settings.users');
        $this->middleware('subscription.feature_usage_check:users')->only(['invite']);

		$this->orgRepository = $orgRepository;
		$this->userRepository = $userRepository;
		$this->orgRoleRepository = $orgRoleRepository;
		$this->roleRepository = $roleRepository;
	}

	public function all(Request $request, string $id)
	{
		// models per page
        $perPage = $request->input('perPage', 30);
        // current page
        $page = $request->input('page', 1);
        // set repository presenter
		$this->orgRepository->setPresenter(OrgUserPresenter::class);

		$users = $this->orgRepository->orgUsers($id);

		return $this->paginate($users['data'], $perPage, []);
	}

    /**
     * @param InviteUser $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function invite(InviteUser $request, string $id)
	{
		$userAttributes = $request->only(['first_name', 'last_name', 'email']);
		$message = $request->get('message');
		// get org
		$org = $this->orgRepository->skipPresenter(true)->find($id);
		// create user
     	$user = $this->userRepository->skipPresenter(true)->create($userAttributes);
     	// get specified org role
     	$orgRole = $this->orgRoleRepository->skipPresenter(true)->find($request->get('org_role_id'));
     	// get 'org_member' role
        $role = $this->roleRepository->skipPresenter(true) ->findWhere(['name' => 'org_member'])->first();
        // associate user with org
        $org->users()->attach($user->id, ['status' => 'pending']);
        // assoicate system role
        $user->roles()->attach($role->id);
        // associate org role
        $user->orgRoles()->attach($orgRole->id, ['org_id' => $id]);

        event(new UserInvited($user, [
        	'message' => $message,
        	'org' => $org
        ]));

        return response()->json(['status' => 'success', 'message' => 'User invitation sent']);
	}

	public function delete(string $id, string $user_id)
    {
        // get org
        $org = $this->orgRepository->skipPresenter(true)->find($id);
        // get 'org_member' role
        $role = $this->roleRepository->skipPresenter(true) ->findWhere(['name' => 'org_member'])->first();
        // get user
        $user = $this->userRepository->skipPresenter()->find($user_id);

        if ($user->memberOf($id)) {
            $this->authorize('remove', $user);

            $org->users()->detach($user->id);
            $user->roles()->detach($role->id);
            $user->detachOrgRoles($id);

            if ($user->delete()) {
                return response()->json(['status' => 'success', 'message' => 'User deleted']);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Action not authorized.'
            ], 403);
        }
    }
}