<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestOrderRequest extends FormRequest
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

        if (str_contains($name_controller, '@setCooker'))
            return [];

        if (str_contains($name_controller, '@start'))
            return [];

        if (str_contains($name_controller, '@finish'))
            return [];
    }

    private function validationStore(): array
    {
        return [
            'items' => 'required|array',
            'table_id' => 'required|numeric|min:1'
        ];
    }

    private function validationIndex(): array
    {
        return [
            'term' => 'sometimes|string|in:pending,preparing,finished,all',
            'pp' => 'sometimes|numeric|min:1',
            'pg' => 'sometimes|numeric|min:1|max:15',
        ];
    }
}
