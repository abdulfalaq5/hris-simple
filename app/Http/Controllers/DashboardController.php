<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Payroll;
use App\Models\Presence;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{

    public function index()
    {
        $employees = Employee::count();
        $departments = Department::count();
        $payrolls = Payroll::count();
        $presences = Presence::count();
        $tasks = Task::get();

        return view('dashboard.index', [
            'employees' => $employees,
            'departments' => $departments,
            'payrolls' => $payrolls,
            'presences' => $presences,
            'tasks' => $tasks
        ]);
    }

    public function presence()
    {
        $data = Presence::getChartPresences();

        return response()->json($data);
    }
}
