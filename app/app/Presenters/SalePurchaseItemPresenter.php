<?php

namespace App\Presenters;

use App\Transformers\SalePurchaseItemTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SaleItemPresenter
 *
 * @package namespace App\Presenters;
 */
class SalePurchaseItemPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SalePurchaseItemTransformer();
    }
}
