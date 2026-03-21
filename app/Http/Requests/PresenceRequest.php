<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresenceRequest extends FormRequest
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
        // $presenceId = $this->route('presence');

        return [
            'employee_id' => 'required|exists:employees,id',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,leave,sick,holiday',
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Employee is required.',
            'employee_id.exists' => 'Selected employee does not exist.',
            'check_in.required' => 'Check In time is required.',
            'check_in.date_format' => 'Check In time must be in HH:MM format.',
            'check_out.date_format' => 'Check Out time must be in HH:MM format.',
            'check_out.after' => 'Check Out time must be after Check In time.',
            'date.required' => 'Date is required.',
            'date.date' => 'Date must be a valid date.',
            'status.required' => 'Status is required.',
            'status.in' => 'Invalid status selected.',
        ];
    }
}
