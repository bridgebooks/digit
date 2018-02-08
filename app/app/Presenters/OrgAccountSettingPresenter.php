<?php

namespace App\Presenters;

use App\Transformers\OrgAccountSettingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OrgAccountSettingPresenter.
 *
 * @package namespace App\Presenters;
 */
class OrgAccountSettingPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrgAccountSettingTransformer();
    }
}
