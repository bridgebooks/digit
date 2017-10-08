<?php

namespace App\Presenters;

use App\Transformers\OrgInvoiceSettingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OrgInvoiceSettingPresenter
 *
 * @package namespace App\Presenters;
 */
class OrgInvoiceSettingPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrgInvoiceSettingTransformer();
    }
}
