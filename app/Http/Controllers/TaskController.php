<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        if (session('role') == 'HR') {
            $tasks = Task::get();
        } else {
            $tasks = Task::where('assigned_to', session('employee_id'))->get();
        }

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    public function create()
    {
        $employees = Employee::get();

        return view('tasks.create', [
            'employees' => $employees,
        ]);
    }

    public function store(TaskRequest $request)
    {

        $task = $request->validated();

        Task::create($task);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $employees = Employee::get();

        return view('tasks.edit', [
            'task' => $task,
            'employees' => $employees,
        ]);
    }

    public function update(TaskRequest $request, Task $task)
    {

        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    public function done(Int $id)
    {
        $task = Task::findOrFail($id);

        $task->update(['status' => 'done']);

        return redirect()->route('tasks.index')->with('success', 'Task marked as done successfully.');
    }

    public function pending(Int $id)
    {
        $task = Task::findOrFail($id);

        $task->update(['status' => 'pending']);

        return redirect()->route('tasks.index')->with('success', 'Task marked as pending successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
