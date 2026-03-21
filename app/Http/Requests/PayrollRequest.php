<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayrollRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:employees,id',
            'salary' => 'required|numeric|min:0',
            'bonuses' => 'required|numeric|min:0',
            'deductions' => 'required|numeric|min:0',
            'net_salary' => 'nullable|numeric',
            'pay_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Employee is required.',
            'employee_id.exists' => 'Selected employee does not exist.',
            'salary.required' => 'Salary is required.',
            'salary.numeric' => 'Salary must be a number.',
            'bonuses.required' => 'Bonuses are required.',
            'bonuses.numeric' => 'Bonuses must be a number.',
            'deductions.required' => 'Deductions are required.',
            'deductions.numeric' => 'Deductions must be a number.',
            'net_salary.numeric' => 'Net salary must be a number.',
            'pay_date.required' => 'Pay date is required.',
            'pay_date.date' => 'Pay date must be a valid date.',
        ];
    }
}
