<?php

namespace App\Presenters;

use App\Transformers\IndustryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class IndustryPresenter
 *
 * @package namespace App\Presenters;
 */
class IndustryPresenter extends FractalPresenter
{
    /**
     * Transformer 
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new IndustryTransformer();
    }
}