<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Payroll extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'payrolls';

    protected $fillable = [
        'employee_id',
        'salary',
        'bonuses',
        'deductions',
        'net_salary',
        'pay_date',
    ];

    public static function getIndexPayrolls()
    {
        $role = session('role');
        $employeeId = auth()->user()->employee_id;

        $sql = "
        SELECT
            p.id,
            p.employee_id,
            p.salary,
            p.bonuses,
            p.deductions,
            p.net_salary,
            p.pay_date,
            e.fullname
        FROM payrolls p
        LEFT JOIN employees e ON p.employee_id = e.id
        WHERE p.deleted_at IS NULL
        AND e.deleted_at IS NULL";


        $bindings = [];

        // Batasi jika bukan HR
        if ($role !== 'HR') {
            $sql .= " AND p.employee_id = ?";
            $bindings[] = $employeeId;
        }

        $sql .= " ORDER BY p.pay_date DESC";

        return DB::select($sql, $bindings);
    }

    public static function filteringPayrolls($bulan, $tahun, $start, $end)
    {
        $sql = "
        SELECT
            p.id,
            p.employee_id,
            p.salary,
            p.bonuses,
            p.deductions,
            p.net_salary,
            p.pay_date,
            e.fullname,
            p.created_at,
            p.updated_at,
            p.deleted_at
        FROM payrolls p
        LEFT JOIN employees e ON p.employee_id = e.id
        WHERE p.deleted_at IS NULL
        AND e.deleted_at IS NULL";

        $bindings = [];

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

        return DB::select($sql, $bindings);
    }
}
