<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Contact;

/**
 * Class ContactTransformer
 * @package namespace App\Transformers;
 */
class ContactTransformer extends TransformerAbstract
{

    /**
     * Transform the \contact entity
     * @param \App\Models\ $model
     *
     * @return array
     */
    public function transform(Contact $model)
    {
        return [
            'id' => $model->id,
            'org_id' => $model->org_id,
            //'user_id' => $model->user_id,
            'type' => $model->type,
            'name' => $model->name,
            'email' => $model->email,
            'phone' => $model->phone,
            'website' => $model->website,
            'address_line_1' => $model->address_line_1,
            'address_line_2' => $model->address_line_2,
            'city_town' => $model->city_town,
            'state_region' => $model->state_region,
            'postal_zip' => $model->postal_zip,
            'country' => $model->country,
            'created_at' => $model->created_at
        ];
    }
}
