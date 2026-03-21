<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'departments';

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public static function filteringDepartments($bulan, $tahun, $status)
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

        return $query->get();
    }
}
