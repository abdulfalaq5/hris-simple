<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presence extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'presences';

    protected $fillable = [
        'employee_id',
        'check_in',
        'check_out',
        'latitude',
        'longitude',
        'date',
        'status',
    ];

    public static function getChartPresences()
    {
        $results = DB::select("
        SELECT
            MONTH(date) AS month,
            COUNT(*) AS total
        FROM presences
        WHERE YEAR(date) = YEAR(CURDATE()) AND deleted_at IS NULL
        GROUP BY MONTH(date)
    ");

        $data = [];
        for ($i = 0; $i < 12; $i++) {
            $data[$i] = 0; // inisialisasi index 0–11
        }

        foreach ($results as $row) {
            $index = (int)$row->month - 1;
            $data[$index] = (int)$row->total;
        }

        return $data;
    }

    public static function getIndexPresences()
    {
        $role = session('role');
        $employeeId = auth()->user()->employee_id;

        $sql = "
        SELECT
            p.id,
            p.employee_id,
            p.check_in,
            p.check_out,
            p.date,
            p.status,
            p.created_at,
            p.updated_at,
            p.deleted_at,
            e.fullname AS employee_fullname
        FROM presences p
        LEFT JOIN employees e ON p.employee_id = e.id
        WHERE p.deleted_at IS NULL
        AND e.deleted_at IS NULL
    ";

        $bindings = [];

        // Batasi jika bukan HR
        if ($role !== 'HR') {
            $sql .= " AND p.employee_id = ?";
            $bindings[] = $employeeId;
        }

        $sql .= " ORDER BY p.date ASC";

        return DB::select($sql, $bindings);
    }

    public static function filteringPresences($bulan, $tahun, $start, $end)
    {
        $role = session('role');
        $employeeId = auth()->user()->employee_id;

        $sql = "
        SELECT
            p.id,
            p.employee_id,
            p.check_in,
            p.check_out,
            p.date,
            p.status,
            p.created_at,
            p.updated_at,
            p.deleted_at,
            e.fullname AS employee_fullname
        FROM presences p
        LEFT JOIN employees e ON p.employee_id = e.id
        WHERE p.deleted_at IS NULL
        AND e.deleted_at IS NULL
    ";

        $bindings = [];

        // Filter bulan
        if (!empty($bulan)) {
            $sql .= " AND MONTH(p.created_at) = ?";
            $bindings[] = $bulan;
        }

        // Filter tahun
        if (!empty($tahun)) {
            $sql .= " AND YEAR(p.created_at) = ?";
            $bindings[] = $tahun;
        }

        // Filter tanggal
        if (!empty($start) && !empty($end)) {
            $sql .= " AND p.date BETWEEN ? AND ?";
            $bindings[] = $start;
            $bindings[] = $end;
        }

        // Filter berdasarkan login jika bukan HR
        if ($role !== 'HR') {
            $sql .= " AND p.employee_id = ?";
            $bindings[] = $employeeId;
        }

        $sql .= " ORDER BY p.date ASC";

        return DB::select($sql, $bindings);
    }
}
