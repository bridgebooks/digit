<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Org;

/**
 * Class OrgTransformer
 * @package namespace App\Transformers;
 */
class OrgTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['industry'];

    /**
     * Include Industry
     * @param Org $org
     * @return \League\Fractal\Resource\Item
     */
    public function includeIndustry(Org $org)
    {
        $industry = $org->industry;

        return $this->item($industry, new IndustryTransformer);
    }
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
            'logo_url' => $model->logo_url,
            'business_name' => $model->business_name,
            'business_reg_no' => $model->business_reg_no,
            'description' => $model->description,
            'industry_id' => $model->industry_id,
            'address_line_1' => $model->address_line_1,
            'address_line_2' => $model->address_line_2,
            'city_town' => $model->city_town,
            'state_region' => $model->state_region,
            'postal_zip' => $model->postal_zip,
            'country' => $model->country,
            'phone' => $model->phone,
            'email' => $model->email,
            'website' => $model->website,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
