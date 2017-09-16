<?php

namespace App\Presenters;

use App\Transformers\AccountTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AccountPresenter
 *
 * @package namespace App\Presenters;
 */
class AccountPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AccountTransformer();
    }
}
