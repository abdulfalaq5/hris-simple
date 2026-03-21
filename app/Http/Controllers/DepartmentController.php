<?php

namespace App\Http\Controllers;

use App\Library\MyHelpers;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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

        $departments = Department::filteringDepartments($search['bulan'], $search['tahun'], $search['status']);
        $list_bulan = MyHelpers::list_bulan();
        $list_tahun = MyHelpers::list_tahun();

        return view('departments.index', [
            'departments' => $departments,
            'list_bulan' => $list_bulan,
            'list_tahun' => $list_tahun,
        ])->with('title', 'Department List')
            ->with('subtitle', 'List of all departments in the system');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create')
            ->with('title', 'Create Department')
            ->with('subtitle', 'Add a new department to the system');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:100|unique:departments,name',
                'description' => 'nullable|max:255',
                'status' => 'required|in:active,inactive',
            ],
            [
                'name.required' => 'Department name is required.',
                'name.max' => 'Department name may not be greater than 100 characters.',
                'name.unique' => 'This department name is already taken.',
                'description.max' => 'Description may not be greater than 255 characters.',
                'status.required' => 'Status is required.',
                'status.in' => 'Status must be either active or inactive.',
            ]
        );

        Department::create($request->all());

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::findOrFail($id);

        return view('departments.show', [
            'department' => $department,
        ])->with('title', 'Department Details')
            ->with('subtitle', 'Details of the selected department');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department = Department::findOrFail($id);

        return view('departments.edit', [
            'department' => $department,
        ])->with('title', 'Edit Department')
            ->with('subtitle', 'Edit the selected department');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name' => 'required|max:100|unique:departments,name,' . $id,
                'description' => 'nullable|max:255',
                'status' => 'required|in:active,inactive',
            ],
            [
                'name.required' => 'Department name is required.',
                'name.max' => 'Department name may not be greater than 100 characters.',
                'name.unique' => 'This department name is already taken.',
                'description.max' => 'Description may not be greater than 255 characters.',
                'status.required' => 'Status is required.',
                'status.in' => 'Status must be either active or inactive.',
            ]
        );

        $department = Department::findOrFail($id);
        $department->update($request->all());

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);

        if ($department->employees()->count() > 0) {
            return redirect()->route('departments.index')->with('error', 'Cannot delete department with existing employees.');
        }

        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
