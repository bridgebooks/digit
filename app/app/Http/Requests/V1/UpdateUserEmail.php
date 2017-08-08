<?php

namespace App\Http\Requests\V1;

use App\Traits\UserRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserEmail extends FormRequest
{
    use UserRequest;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->requestUser()) return true;

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email'
        ];
    }
}
