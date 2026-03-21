<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        // Dapatkan employee id nya.
        $employeeID = auth()->user()->employee_id;

        // Cari tahu rolenya.
        $employee = Employee::find($employeeID);

        // Daftarkan rolenya ke dalam session.
        $request->session()->put('role', $employee->role->title);
        $request->session()->put('employee_id', $employee->id);

        // Jika rolenya tidak sesuai, redirect sesuai role bukan abort 403.
        if (!in_array($employee->role->title, $roles)) {
            if ($employee->role->title === 'Sales') {
                return redirect('/sales');
            }
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
