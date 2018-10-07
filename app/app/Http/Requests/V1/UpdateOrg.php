<?php

namespace App\Http\Requests\V1;

use App\Rules\Website;
use App\Traits\UserRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrg extends FormRequest
{
    use UserRequest;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->userHasRole('org_admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'email|unique:orgs,email',
            'website' => [new Website]
        ];
    }
}
