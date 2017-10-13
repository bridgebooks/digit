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
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
