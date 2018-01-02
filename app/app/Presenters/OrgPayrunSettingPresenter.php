<?php

namespace App\Presenters;

use App\Transformers\OrgPayrunSettingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OrgPayrunSettingPresenter
 *
 * @package namespace App\Presenters;
 */
class OrgPayrunSettingPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrgPayrunSettingTransformer();
    }
}
