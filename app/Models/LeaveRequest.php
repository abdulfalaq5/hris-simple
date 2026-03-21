<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class LeaveRequest extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'leave_requests';

    protected $fillable = [
        'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'status',
    ];

    public $timestamps = false;

    public static function getLeaveRequest()
    {
        $role = session('role');
        $employeeId = auth()->user()->employee_id;

        $sql = "
        SELECT l.id, l.employee_id, l.leave_type, l.start_date, l.end_date, l.status, e.fullname
        FROM leave_requests l
        LEFT JOIN employees e ON l.employee_id = e.id
        WHERE l.deleted_at IS NULL
        ";

        $bindings = [];

        if ($role !== 'HR') {
            $sql .= " AND l.employee_id = ?";
            $bindings[] = $employeeId;
        }

        return DB::select($sql, $bindings);
    }
}
