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
    protected $availableIncludes = ['people', 'bank', 'group'];

    /**
     * @param Contact $contact
     * @return \League\Fractal\Resource\Collection
     */
    public function includePeople(Contact $contact)
    {
        $people = $contact->people;

        return $this->collection($people, new ContactPersonTransformer);
    }

    /**
     * @param Contact $contact
     * @return \League\Fractal\Resource\Item
     */
    public function includeBank(Contact $contact)
    {
        $bank = $contact->bank;

        if ($bank) return $this->item($bank, new BankTransformer);
    }

    public function includeGroup(Contact $contact)
    {
        $group = $contact->group;

        if($group) return $this->item($group, new ContactGroupTransformer);
    }

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
            'user_id' => $model->user_id,
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
            'group' => $model->group ? [
                'id' => $model->group->id,
                'name' => $model->group->name,
                'description' => $model->group->description
            ] : null,
            'bank_id' => $model->bank_id,
            'bank_account_name' => $model->bank_account_name,
            'bank_account_no' =>$model->bank_account_no,
            'created_at' => $model->created_at
        ];
    }
}
