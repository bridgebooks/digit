<?php

namespace App\Presenters;

use App\Transformers\PayslipItemTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PayslipItemPresenter
 *
 * @package namespace App\Presenters;
 */
class PayslipItemPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PayslipItemTransformer();
    }
}
