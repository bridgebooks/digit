<?php

namespace App\Presenters;

use App\Transformers\PayslipTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PayslipPresenter
 *
 * @package namespace App\Presenters;
 */
class PayslipPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PayslipTransformer();
    }
}
