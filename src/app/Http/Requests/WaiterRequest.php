<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WaiterRequest extends FormRequest
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

        if (str_contains($name_controller, '@getRequestOrdersByWaiter'))
            return $this->validationGetRequestOrdersByWaiter();
    }

    private function validationGetRequestOrdersByWaiter(): array
    {
        return [
            'term' => 'required|string|in:pending,preparing,finished,all',
            'pp' => 'required|numeric|min:1',
            'pg' => 'sometimes|numeric|min:1|max:15',
        ];
    }
}
