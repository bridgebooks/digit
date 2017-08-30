<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OrgContactsCriteria
 * @package namespace App\Criteria;
 */
class OrgContactsCriteria implements CriteriaInterface
{
    private $orgId;

    private $type;

    public function __construct(string $orgId, string $type)
    {
        $this->orgId = $orgId;
        $this->type = $type;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('org_id', $this->orgId)->where('type', $this->type);
        return $model;
    }
}
