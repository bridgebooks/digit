<?php

namespace App\Presenters;

use App\Transformers\AccountTypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AccountTypePresenter
 *
 * @package namespace App\Presenters;
 */
class AccountTypePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AccountTypeTransformer();
    }
}
