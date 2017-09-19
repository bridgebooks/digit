<?php

namespace App\Presenters;

use App\Transformers\TaxRateComponentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TaxRateComponentPresenter
 *
 * @package namespace App\Presenters;
 */
class TaxRateComponentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TaxRateComponentTransformer();
    }
}
