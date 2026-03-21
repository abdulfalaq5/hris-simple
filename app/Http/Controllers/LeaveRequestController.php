<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Library\MyHelpers;
use App\Models\Employee;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $leaveRequests = LeaveRequest::getLeaveRequest();
        $list_tahun = MyHelpers::list_tahun();
        $list_bulan = MyHelpers::list_bulan();

        return view('leave-request.index', [
            'leaveRequests' => $leaveRequests,
            'list_bulan' => $list_bulan,
            'list_tahun' => $list_tahun
        ])->with(['title' => 'Leave Request List', 'subtitle' => 'List of all leave request in the system']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::get();

        return view('leave-request.create', [
            'employees' => $employees
        ])->with(['title' => 'Create Leave Request', 'subtitle' => 'Add new leave request to the system']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (session('role') == 'HR') {
            $request->validate(
                [
                    'employee_id' => 'required',
                    'leave_type' => 'required|string',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date'
                ],
                [
                    'employee_id.required' => 'Employee is required.',
                    'leave_type.required' => 'Leave Type is required.',
                    'start_date.required' => 'Start Date is required.',
                    'start_date.date' => 'Start Date must be a valid date.',
                    'end_date.required' => 'End Date is required.',
                    'end_date.date' => 'End Date must be a valid date.'
                ]
            );

            $request->merge([
                'status' => 'pending'
            ]);

            LeaveRequest::create($request->all());

            return redirect()->route('leave-requests.index')->with('success', 'Leave request created successfully.');
        } else {
            LeaveRequest::create([
                'employee_id' => session('employee_id'),
                'leave_type' => $request->leave_type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'pending'
            ]);

            $request->merge([
                'status' => 'pending'
            ]);

            return redirect()->route('leave-requests.index')->with('success', 'Leave request created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $employees = Employee::get();

        return view('leave-request.edit', [
            'leaveRequest' => $leaveRequest,
            'employees' => $employees
        ])->with(['title' => 'Edit Leave Request', 'subtitle' => 'Edit leave request in the system']);
    }
    public function confirm(string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update([
            'status' => 'approved'
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'Leave request approved successfully.');
    }

    public function reject(string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update([
            'status' => 'rejected'
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'Leave request rejected successfully.');
    }
    /**
     *
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'employee_id' => 'required',
                'leave_type' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date'
            ],
            [
                'employee_id.required' => 'Employee is required.',
                'leave_type.required' => 'Leave Type is required.',
                'start_date.required' => 'Start Date is required.',
                'start_date.date' => 'Start Date must be a valid date.',
                'end_date.required' => 'End Date is required.',
                'end_date.date' => 'End Date must be a valid date.'
            ]
        );

        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update($request->all());

        return redirect()->route('leave-requests.index')->with('success', 'Leave request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->delete();

        return redirect()->route('leave-requests.index')->with('success', 'Leave request deleted successfully.');
    }
}
