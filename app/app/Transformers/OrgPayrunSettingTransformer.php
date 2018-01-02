<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\OrgPayrunSetting;

/**
 * Class OrgPayrunSettingTransformer
 * @package namespace App\Transformers;
 */
class OrgPayrunSettingTransformer extends TransformerAbstract
{

    /**
     * Transform the \OrgPayrunSetting entity
     * @param \OrgPayrunSetting $model
     *
     * @return array
     */
    public function transform(OrgPayrunSetting $model)
    {
        return [
            'id' => $model->id,
            'org_id' => $model->org_id,
            'values' => $model->values
        ];
    }
}
