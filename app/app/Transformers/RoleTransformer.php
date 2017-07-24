<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Role;

/**
 * Class RoleTransformer
 * @package namespace App\Transformers;
 */
class RoleTransformer extends TransformerAbstract
{

    /**
     * Transform the \Role entity
     * @param \Role $model
     *
     * @return array
     */
    public function transform(Role $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'permissions' => $model->permissions,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
