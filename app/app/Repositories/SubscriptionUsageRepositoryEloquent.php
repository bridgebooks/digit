<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SubscriptionUsageRepository;
use App\Models\SubscriptionUsage;
use App\Validators\SubscriptionUsageValidator;

/**
 * Class SubscriptionUsageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SubscriptionUsageRepositoryEloquent extends BaseRepository implements SubscriptionUsageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SubscriptionUsage::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
