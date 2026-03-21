<?php

namespace App\Http\Controllers;

use App\Library\MyHelpers;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = [
            'bulan' => request()->input('b', ''),
            'tahun' => request()->input('t', ''),
        ];
        $roles = Role::filteringRoles($search['bulan'], $search['tahun']);
        $list_bulan = MyHelpers::list_bulan();
        $list_tahun = MyHelpers::list_tahun();

        return view('roles.index', [
            'roles' => $roles,
            'list_bulan' => $list_bulan,
            'list_tahun' => $list_tahun,
        ])->with('title', 'Role List')
            ->with('subtitle', 'List of all roles in the system');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create')
            ->with('title', 'Create Role')
            ->with('subtitle', 'Add a new role to the system');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|max:100|unique:roles,title',
                'description' => 'nullable|max:255',
            ],
            [
                'title.required' => 'Role title is required.',
                'title.max' => 'Role title may not be greater than 100 characters.',
                'title.unique' => 'This role name is already taken.',
                'description.max' => 'Description may not be greater than 255 characters.',
            ]
        );

        Role::create($request->all());

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);

        return view('roles.show', [
            'role' => $role,
        ])->with('title', 'Role Details')
            ->with('subtitle', 'Details of the selected role');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);

        return view('roles.edit', [
            'role' => $role,
        ])->with('title', 'Edit Role')
            ->with('subtitle', 'Edit the selected role');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'title' => 'required|max:100|unique:roles,title,' . $id,
                'description' => 'nullable|max:255',
            ],
            [
                'title.required' => 'Role title is required.',
                'title.max' => 'Role title may not be greater than 100 characters.',
                'title.unique' => 'This role name is already taken.',
                'description.max' => 'Description may not be greater than 255 characters.',
            ]
        );

        $role = Role::findOrFail($id);
        $role->update($request->all());

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        if ($role->employees()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'Cannot delete role with existing employees.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
