<?php

namespace App\Presenters;

use App\Transformers\PayitemTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PayitemPresenter
 *
 * @package namespace App\Presenters;
 */
class PayitemPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PayitemTransformer();
    }
}
