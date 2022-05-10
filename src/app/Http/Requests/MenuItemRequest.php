<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
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
            'menu_id' => 'required|numeric|min:1',
            'name' => 'required|string|min:3|max: 60',
            'price' => 'required|numeric|min:0',
        ];
    }

    /**
     * @return array
     */
    private function validationUpdate(): array
    {
        return [
            'menu_id' => 'sometimes|numeric',
            'name' => 'sometimes|string|min:3|max: 60',
            'price' => 'sometimes|numeric',
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
