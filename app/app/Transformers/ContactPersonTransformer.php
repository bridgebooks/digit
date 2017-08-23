<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ContactPerson;

/**
 * Class ContactPersonTransformer
 * @package namespace App\Transformers;
 */
class ContactPersonTransformer extends TransformerAbstract
{

    /**
     * Transform the \ContactPerson entity
     * @param \ContactPerson $model
     *
     * @return array
     */
    public function transform(ContactPerson $model)
    {
        return [
            'id' => $model->id,
            'first_name' => $model->first_name,
            'last_name' => $model->last_name,
            'email' => $model->email,
            'phone' => $model->phone,
            'role' => $model->role,
            'is_primary_contact' => (bool) $model->is_primary_contact,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
