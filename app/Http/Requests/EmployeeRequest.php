<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
        $employeeId = $this->route('employee');

        return [
            'fullname' => 'required|max:100',
            'email' => 'required|email|unique:employees,email,' . $employeeId,
            'phone_number' => 'required|numeric|digits_between:8,15|unique:employees,phone_number,' . $employeeId,
            'address' => 'required|max:255',
            'birth_date' => 'required|date|before:today',
            'hire_date' => 'required|date|after_or_equal:birth_date',
            'department_id' => 'required|exists:departments,id',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive',
            'salary' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => 'Full Name is required.',
            'fullname.max' => 'Full Name may not be greater than 100 characters.',

            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already taken.',

            'phone_number.required' => 'Phone Number is required.',
            'phone_number.numeric' => 'Phone Number must contain only numbers.',
            'phone_number.digits_between' => 'Phone Number must be between 8 and 15 digits.',
            'phone_number.unique' => 'This phone number is already taken.',

            'address.required' => 'Address is required.',
            'address.max' => 'Address may not be greater than 255 characters.',

            'birth_date.required' => 'Birth Date is required.',
            'birth_date.date' => 'Birth Date must be a valid date.',
            'birth_date.before' => 'Birth Date must be before today.',

            'hire_date.required' => 'Hire Date is required.',
            'hire_date.date' => 'Hire Date must be a valid date.',
            'hire_date.after_or_equal' => 'Hire Date must be after or equal to Birth Date.',

            'department_id.required' => 'Department is required.',
            'department_id.exists' => 'Selected Department does not exist.',

            'role_id.required' => 'Role is required.',
            'role_id.exists' => 'Selected Role does not exist.',

            'status.required' => 'Status is required.',
            'status.in' => 'Invalid status selected.',

            'salary.required' => 'Salary is required.',
            'salary.numeric' => 'Salary must be a numeric value.',
            'salary.min' => 'Salary cannot be negative.',
        ];
    }
}
