<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\OrgAccountSetting;

/**
 * Class OrgAccountSettingTransformer.
 *
 * @package namespace App\Transformers;
 */
class OrgAccountSettingTransformer extends TransformerAbstract
{
    /**
     * Transform the OrgAccountSetting entity.
     *
     * @param \App\Models\OrgAccountSetting $model
     *
     * @return array
     */
    public function transform(OrgAccountSetting $model)
    {
        return [
            'id' => $model->id,
            'org_id' => $model->org_id,
            'values' => $model->values
        ];
    }
}
