<?php

namespace App\Presenters;

use App\Transformers\ContactGroupTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ContactGroupPresenter
 *
 * @package namespace App\Presenters;
 */
class ContactGroupPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ContactGroupTransformer();
    }
}