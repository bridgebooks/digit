<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/01/2018
 * Time: 10:54
 */

namespace App\Repositories;

use App\Models\User;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Subscription;
use App\Presenters\SubscriptionPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

class SubscriptionRepositoryEloquent extends BaseRepository implements SubscriptionRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subscription::class;
    }

    public function presenter()
    {
        return SubscriptionPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get active subscription
     * @param User $user
     * @return mixed
     */
    public function active(User $user)
    {
        $this->applyCriteria();
        $this->applyScope();

        $result = $user->getActiveSubscription() ? $user->getActiveSubscription() : $user->getLastActiveSubscription();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($result);
    }
}