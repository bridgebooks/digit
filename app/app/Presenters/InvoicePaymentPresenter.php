<?php

namespace App\Presenters;

use App\Transformers\InvoicePaymentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class InvoicePaymentPresenter.
 *
 * @package namespace App\Presenters;
 */
class InvoicePaymentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new InvoicePaymentTransformer();
    }
}
