<?php

namespace App\Presenters;

use App\Transformers\OrgUserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OrgUserPresenter
 *
 * @package namespace App\Presenters;
 */
class OrgUserPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrgUserTransformer();
    }
}
