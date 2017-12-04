<?php

namespace App\Http\Requests\V1;

use App\Traits\UserRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreatePayItem extends FormRequest
{
    use UserRequest;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $org = $this->request->get('org_id');
        return $this->belongsToOrg($org);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'org_id' => 'required|exists:orgs,id',
            'name' => 'required',
            'account_id' => 'required',
            'pay_item_type' => 'required',
            'mark_default' => 'boolean',
            'default_amount' => 'numeric'
        ];
    }
}
