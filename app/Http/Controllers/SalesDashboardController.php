<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use App\Models\Presence;
use App\Library\MyHelpers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesDashboardController extends Controller
{
    /**
     * Sales Dashboard - ringkasan data milik sendiri.
     */
    public function index()
    {
        $employeeId = session('employee_id');

        $totalPresences = Presence::where('employee_id', $employeeId)->count();
        $totalPayrolls  = Payroll::where('employee_id', $employeeId)->count();

        // Hitung sisa cuti: jatah 12 hari per tahun dikurangi yang approved
        $tahunIni = Carbon::now()->year;
        $cutiTerpakai = LeaveRequest::where('employee_id', $employeeId)
            ->where('status', 'approved')
            ->whereYear('start_date', $tahunIni)
            ->get()
            ->sum(function ($lr) {
                $start = Carbon::parse($lr->start_date);
                $end   = Carbon::parse($lr->end_date);
                return $start->diffInDays($end) + 1;
            });

        $jatahCuti    = 12;
        $sisaCuti     = max(0, $jatahCuti - $cutiTerpakai);

        $pendingLeave = LeaveRequest::where('employee_id', $employeeId)
            ->where('status', 'pending')
            ->count();

        $employee = Employee::with(['department', 'role'])->find($employeeId);

        return view('sales.dashboard', compact(
            'totalPresences',
            'totalPayrolls',
            'sisaCuti',
            'cutiTerpakai',
            'jatahCuti',
            'pendingLeave',
            'employee'
        ));
    }

    /**
     * Presences milik sendiri.
     */
    public function presences(Request $request)
    {
        $employeeId = session('employee_id');

        $bulan = $request->input('b', '');
        $tahun = $request->input('t', '');
        $start = $request->input('start', '');
        $end   = $request->input('end', '');

        $sql = "
            SELECT p.*, e.fullname AS employee_fullname
            FROM presences p
            LEFT JOIN employees e ON p.employee_id = e.id
            WHERE p.deleted_at IS NULL
            AND p.employee_id = ?
        ";
        $bindings = [$employeeId];

        if ($bulan) {
            $sql .= " AND MONTH(p.date) = ?";
            $bindings[] = $bulan;
        }
        if ($tahun) {
            $sql .= " AND YEAR(p.date) = ?";
            $bindings[] = $tahun;
        }
        if ($start && $end) {
            $sql .= " AND p.date BETWEEN ? AND ?";
            $bindings[] = $start;
            $bindings[] = $end;
        }

        $sql .= " ORDER BY p.date DESC";

        $presences = DB::select($sql, $bindings);

        return view('sales.presences', [
            'presences'  => $presences,
            'list_bulan' => MyHelpers::list_bulan(),
            'list_tahun' => MyHelpers::list_tahun(),
        ]);
    }

    /**
     * Payrolls milik sendiri.
     */
    public function payrolls(Request $request)
    {
        $employeeId = session('employee_id');

        $bulan = $request->input('b', '');
        $tahun = $request->input('t', '');
        $start = $request->input('start', '');
        $end   = $request->input('end', '');

        $sql = "
            SELECT p.*, e.fullname
            FROM payrolls p
            LEFT JOIN employees e ON p.employee_id = e.id
            WHERE p.deleted_at IS NULL
            AND e.deleted_at IS NULL
            AND p.employee_id = ?
        ";
        $bindings = [$employeeId];

        if ($bulan) {
            $sql .= " AND MONTH(p.pay_date) = ?";
            $bindings[] = $bulan;
        }
        if ($tahun) {
            $sql .= " AND YEAR(p.pay_date) = ?";
            $bindings[] = $tahun;
        }
        if ($start && $end) {
            $sql .= " AND p.pay_date BETWEEN ? AND ?";
            $bindings[] = $start;
            $bindings[] = $end;
        }

        $sql .= " ORDER BY p.pay_date DESC";

        $payrolls = DB::select($sql, $bindings);

        return view('sales.payrolls', [
            'payrolls'   => $payrolls,
            'list_bulan' => MyHelpers::list_bulan(),
            'list_tahun' => MyHelpers::list_tahun(),
        ]);
    }

    /**
     * Leave requests milik sendiri + sisa jatah cuti.
     */
    public function leaveRequests(Request $request)
    {
        $employeeId = session('employee_id');
        $tahunIni   = Carbon::now()->year;

        $leaveRequests = DB::select("
            SELECT l.id, l.employee_id, l.leave_type, l.start_date, l.end_date, l.status, e.fullname
            FROM leave_requests l
            LEFT JOIN employees e ON l.employee_id = e.id
            WHERE l.deleted_at IS NULL
            AND l.employee_id = ?
            ORDER BY l.start_date DESC
        ", [$employeeId]);

        // Hitung sisa cuti
        $approved = LeaveRequest::where('employee_id', $employeeId)
            ->where('status', 'approved')
            ->whereYear('start_date', $tahunIni)
            ->get();

        $cutiTerpakai = $approved->sum(function ($lr) {
            $start = Carbon::parse($lr->start_date);
            $end   = Carbon::parse($lr->end_date);
            return $start->diffInDays($end) + 1;
        });

        $jatahCuti = 12;
        $sisaCuti  = max(0, $jatahCuti - $cutiTerpakai);

        return view('sales.leave-requests', [
            'leaveRequests' => $leaveRequests,
            'sisaCuti'      => $sisaCuti,
            'cutiTerpakai'  => $cutiTerpakai,
            'jatahCuti'     => $jatahCuti,
            'list_bulan'    => MyHelpers::list_bulan(),
            'list_tahun'    => MyHelpers::list_tahun(),
        ]);
    }

    /**
     * Store leave request dari Sales.
     */
    public function storeLeaveRequest(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        LeaveRequest::create([
            'employee_id' => session('employee_id'),
            'leave_type'  => $request->leave_type,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'status'      => 'pending',
        ]);

        return redirect()->route('sales.leave-requests')->with('success', 'Leave request submitted successfully.');
    }
}
