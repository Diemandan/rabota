<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryRequest extends FormRequest
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
            'id' => 'sometimes|integer|exists:salaries,id',
            'cadence_id' => 'required',
            'transfer_date' => 'required|date',
            'transfer_amount' => 'required|numeric|min:0.01',
        ];
    }
}
