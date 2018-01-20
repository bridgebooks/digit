<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Exceptions\UserModelNotFoundException;
use App\Exceptions\VerificationTokenMismatch;
use App\Repositories\UserRepository;
use App\Models\User;
use App\Presenters\UserPresenter;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return UserPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    private function validateVerificationToken(User $user, String $token) {
        if($user->verification_token != $token) return false;

        return true;
    }

    public function byEmail(string $email)
    {
        $this->applyCriteria();
        $this->applyScope();

        $result = $this->model->where('email', $email)->first();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($result);
    }

    public function validateUser(String $id, String $password, String $validateToken)
    {
        $this->skipPresenter(true);
        $model = $this->model->find($id);

        if(!$model) 
            throw new UserModelNotFoundException('User not found!');

        if(!$this->validateVerificationToken($model, $validateToken))
            throw new VerificationTokenMismatch('Invalid verification token');

        $model->is_verified = true;
        $model->verification_token = NULL;
        $model->password = Hash::make($password);
        $model->save();

        return $this->parserResult($model);
    }
}
