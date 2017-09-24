<?php

namespace App\Presenters;

use App\Transformers\OrgBankAccountTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OrgBankAccountPresenter
 *
 * @package namespace App\Presenters;
 */
class OrgBankAccountPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrgBankAccountTransformer();
    }
}
