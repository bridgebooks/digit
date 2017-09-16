<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\UserRequest;

class CreateSalePurchaseItem extends FormRequest
{
    use UserRequest;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->userHasRole('org_admin') || 
        $this->userHasRole('org_member') && 
        $this->belongsToOrg($this->request->get('org_id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'code' => 'required|max:5',
            'org_id' => 'required|exists:orgs,id',
        ];
    }
}
