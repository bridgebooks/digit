<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AccountTypeRepository;
use App\Models\AccountType;
use App\Validators\AccountTypeValidator;

/**
 * Class AccountTypeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AccountTypeRepositoryEloquent extends BaseRepository implements AccountTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AccountType::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
