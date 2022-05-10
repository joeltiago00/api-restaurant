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

        if (str_contains($name_controller, '@update'))
            return $this->validationUpdate();

        if (str_contains($name_controller, '@setCooker'))
            return [];

        if (str_contains($name_controller, '@start'))
            return [];

        if (str_contains($name_controller, '@finish'))
            return [];

        if (str_contains($name_controller, '@index'))
            return $this->validationIndex();

        if (str_contains($name_controller, '@create'))
            return $this->validationCreate();
    }

    /**
     * @return array
     */
    private function validationStore(): array
    {
        return [
            'items' => 'required|array',
            'table_id' => 'required|numeric|min:1',
            'customer_id' => 'required|numeric|min:1',
        ];
    }

    /**
     * @return array
     */
    private function validationUpdate(): array
    {
        return [
            'items' => 'sometimes|array',
            'table_id' => 'sometimes|numeric',
            'cooker_id' => 'sometimes|numeric',
            'costumer_id' => 'sometimes|numeric',
        ];
    }

    /**
     * @return array
     */
    private function validationIndex(): array
    {
        return [
            'term' => 'required|string|in:pending,preparing,finished,all',
            'filter_type' => 'required|string:day,week,month,by_table,by_client',
            'filter_value' => 'sometimes',
            'pp' => 'required|numeric|min:1',
            'pg' => 'sometimes|numeric|min:1|max:15',
        ];
    }

    /**
     * @return array
     */
    private function validationCreate(): array
    {
        return [
            'pp' => 'required|numeric|min:1',
        ];
    }
}
