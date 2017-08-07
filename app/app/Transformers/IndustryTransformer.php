<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Industry;

/**
 * Class IndustryTransformer
 * @package namespace App\Transformers;
 */
class IndustryTransformer extends TransformerAbstract
{

    /**
     * Transform the \Industry entity
     * @param \Industry $model
     *
     * @return array
     */
    public function transform(Industry $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'slug' => $model->slug
        ];
    }
}
