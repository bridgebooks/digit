<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\OrgRole;

/**
 * Class OrgRoleTransformer
 * @package namespace App\Transformers;
 */
class OrgRoleTransformer extends TransformerAbstract
{

    /**
     * Transform the \OrgRole entity
     * @param \OrgRole $model
     *
     * @return array
     */
    public function transform(OrgRole $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'short_description' => $model->short_description,
            'description' => $model->description,
            'permissions' => $model->permissions
        ];
    }
}
