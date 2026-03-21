<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Library\MyHelpers;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Task;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = [
            'bulan' => ($request->has('b') ?  $request->input('b') : ''),
            'tahun' => ($request->has('t') ?  $request->input('t') : ''),
            'status' => ($request->has('a') ?  $request->input('a') : ''),
        ];

        $employees = Employee::filteringEmployees($search['bulan'], $search['tahun'], $search['status']);

        return view('employees.index', [
            'employees' => $employees,
            'list_bulan' => MyHelpers::list_bulan(),
            'list_tahun' => MyHelpers::list_tahun(),
        ])->with('title', 'Employee List')
            ->with('subtitle', 'List of all employees in the system');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::get();
        $roles = Role::get();

        return view('employees.create', [
            'departments' => $departments,
            'roles' => $roles,
        ])->with('title', 'Create Employee')->with('subtitle', 'Add a new employee to the system');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $employees = $request->validated();

        Employee::create($employees);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employees = Employee::findOrFail($id);

        return view('employees.show', [
            'employees' => $employees,
        ])->with('title', 'Employee Details')
            ->with('subtitle', 'Details of the selected employee');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::get();
        $roles = Role::get();

        return view('employees.edit', [
            'employee' => $employee,
            'departments' => $departments,
            'roles' => $roles,
        ])->with('title', 'Edit Employee')
            ->with('subtitle', 'Edit details of the selected employee');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, string $id)
    {
        $employee = Employee::findOrFail($id);
        $data = $request->validated();

        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $taskEmployee = Task::where('assigned_to', $id)->first();

        if ($taskEmployee) {
            return redirect()->route('employees.index')->with('error', 'Cannot delete employee because they have assigned tasks.');
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
