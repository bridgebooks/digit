<?php

namespace App\Presenters;

use App\Transformers\PlanTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PlanPresenter.
 *
 * @package namespace App\Presenters;
 */
class PlanPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PlanTransformer();
    }
}
