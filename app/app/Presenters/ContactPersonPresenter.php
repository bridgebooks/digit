<?php

namespace App\Presenters;

use App\Transformers\ContactPersonTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ContactPersonPresenter
 *
 * @package namespace App\Presenters;
 */
class ContactPersonPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ContactPersonTransformer();
    }
}