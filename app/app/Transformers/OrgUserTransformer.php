<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

/**
 * Class OrgUserTransformer
 * @package namespace App\Transformers;
 */
class OrgUserTransformer extends TransformerAbstract
{

    /**
     * Transform the \OrgUser entity
     * @param \OrgUser $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id' => $model->id,
            'first_name' => $model->first_name,
            'last_name' => $model->last_name,
            'email' => $model->email,
            'status' => $model->pivot->status,
            'roles' => $model->roles,
            'org_roles' => $model->orgRoles,
            'created_at' => $model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at->getTimestamp() * 1000,
        ];
    }
}
