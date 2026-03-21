<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'title' => 'required|max:100',
            'description' => 'nullable',
            'assigned_to' => 'required|exists:employees,id',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:pending,done,on progress',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Task Title is required.',
            'title.max' => 'Task Title may not be greater than 100 characters.',
            'assigned_to.required' => 'Please select an employee.',
            'assigned_to.exists' => 'Selected employee does not exist.',
            'due_date.required' => 'Due date is required.',
            'due_date.date' => 'Due date must be a valid date.',
            'due_date.after_or_equal' => 'Due date must be today or later.',
            'status.required' => 'Status is required.',
            'status.in' => 'Invalid status selected.',
        ];
    }
}
