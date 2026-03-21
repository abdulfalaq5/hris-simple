<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fullname',
        'email',
        'phone_number',
        'address',
        'birth_date',
        'hire_date',
        'status',
        'department_id',
        'role_id',
        'salary',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public static function filteringEmployees($bulan, $tahun, $status)
    {
        $query = self::query()->whereNotNull('created_at');

        if (!empty($bulan)) {
            $query->whereMonth('created_at', $bulan);
        }

        if (!empty($tahun)) {
            $query->whereYear('created_at', $tahun);
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        return $query->orderByDesc('created_at')->get();
    }
}
