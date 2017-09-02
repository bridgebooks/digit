<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ContactGroup;

/**
 * Class ContactGroupTransformer
 * @package namespace App\Transformers;
 */
class ContactGroupTransformer extends TransformerAbstract
{

    /**
     * Transform the \ContactGroup entity
     * @param \ContactGroup $model
     *
     * @return array
     */
    public function transform(ContactGroup $model)
    {
        return [
            'id' => $model->id,
            'org_id' => $model->org_id,
            'name' => $model->name,
            'description' => $model->description
        ];
    }
}
