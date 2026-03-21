<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public static function filteringRoles($bulan, $tahun)
    {
        $query = self::query()->whereNotNull('created_at');

        if (!empty($bulan)) {
            $query->whereMonth('created_at', $bulan);
        }

        if (!empty($tahun)) {
            $query->whereYear('created_at', $tahun);
        }

        return $query->orderByDesc('created_at')->get();
    }
}
