<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
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
            return [];
    }

    private function validationStore(): array
    {
        return [
            'number' => 'required|numeric|min:1',
            'quantity_seats' => 'required|numeric|min:1',
        ];
    }

    private function validationUpdate(): array
    {
        return [
            'number' => 'sometimes|numeric|min:1',
            'quantity_seats' => 'sometimes|numeric|min:1',
        ];
    }
}
