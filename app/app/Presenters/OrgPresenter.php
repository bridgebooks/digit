<?php

namespace App\Presenters;

use App\Transformers\OrgTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OrgPresenter
 *
 * @package namespace App\Presenters;
 */
class OrgPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrgTransformer();
    }
}