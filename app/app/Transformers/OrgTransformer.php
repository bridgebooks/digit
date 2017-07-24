<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Org;

/**
 * Class OrgTransformer
 * @package namespace App\Transformers;
 */
class OrgTansformer extends TransformerAbstract
{

    /**
     * Transform the \Org entity
     * @param \Org $model
     *
     * @return array
     */
    public function transform(Org $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'business_name' => $model->business_name,
            'permissions' => $model->permissions,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
