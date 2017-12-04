<?php

namespace App\Presenters;

use App\Transformers\PayrunTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PayrunPresenter
 *
 * @package namespace App\Presenters;
 */
class PayrunPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PayrunTransformer();
    }
}
