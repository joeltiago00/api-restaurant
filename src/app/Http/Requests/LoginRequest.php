<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $name_controller = $this->route()->action['controller'];

        if (str_contains($name_controller, '@login'))
            return $this->validationLogin();
    }

    /**
     * @return array
     */
    private function validationLogin(): array
    {
        return [
            'email' => 'required|email:rfc,filter',
            'password' => 'required|string|min:8|max:128',
        ];
    }
}
