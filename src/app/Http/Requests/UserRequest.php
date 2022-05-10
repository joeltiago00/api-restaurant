<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $name_controller = $this->route()->action['controller'];

        if (str_contains($name_controller, '@store'))
            return $this->validationStore();

        if (str_contains($name_controller, '@update'))
            return $this->validationUpdate();

        if (str_contains($name_controller, '@index'))
            return $this->validationIndex();
    }

    /**
     * @return array
     */
    private function validationStore(): array
    {
        return [
            'first_name' => 'required|string|min:3|max:20',
            'last_name' => 'required|string|min:3|max: 60',
            'document.type' => 'required|string|in:cpf',
            'document.value' => 'required|string|min:11|max:11',
            'email' => 'required|email:rfc,filter|unique:users',
            'password' => 'required|string|min:8|max:16',
            'job_function_id' => 'required|numeric|min:1',
            'role_id' => 'required|numeric|min:1'
        ];
    }

    /**
     * @return array
     */
    private function validationUpdate(): array
    {
        return [
            'first_name' => 'sometimes|string|min:3|max:20',
            'last_name' => 'sometimes|string|min:3|max: 60',
        ];
    }

    /**
     * @return array
     */
    private function validationIndex(): array
    {
        return [
            'pp' => 'required|numeric|min:1',
        ];
    }
}
