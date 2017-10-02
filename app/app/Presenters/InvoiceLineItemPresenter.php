<?php

namespace App\Presenters;

use App\Transformers\InvoiceLineItemTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class InvoiceLineItemPresenter
 *
 * @package namespace App\Presenters;
 */
class InvoiceLineItemPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new InvoiceLineItemTransformer();
    }
}
