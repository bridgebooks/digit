<?php

namespace App\Presenters;

use App\Transformers\OrgRoleTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OrgRolePresenter
 *
 * @package namespace App\Presenters;
 */
class OrgRolePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrgRoleTransformer();
    }
}
