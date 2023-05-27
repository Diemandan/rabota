<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CadenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [

            'id' => 'required|integer',
            'daily_rate' => 'sometimes|required_if:id,0',
            'start' => 'sometimes|required_if:id,0',
            'finish' => 'sometimes|required_if:id,0',
        ];
    }
}
