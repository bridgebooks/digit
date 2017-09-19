<?php

namespace App\Presenters;

use App\Transformers\TaxRateTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TaxRatePresenter
 *
 * @package namespace App\Presenters;
 */
class TaxRatePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TaxRateTransformer();
    }
}
