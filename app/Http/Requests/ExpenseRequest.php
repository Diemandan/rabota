<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
            'id' => 'sometimes|integer|exists:expenses,id',
            'cadence_id' => 'required|integer|exists:cadences,id',
            'payment_date' => 'required|date',
            'payment_amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:500'
        ];
    }
}
