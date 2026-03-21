<?php

namespace App\Library;

use Illuminate\Support\Facades\Request;

class MyHelpers
{
    public static function list_tahun()
    {
        $tahun = [];
        for ($i = 2020; $i <= intval(date("Y")); $i++) {
            $tahun[$i] = $i;
        }
        return $tahun;
    }

    public static function list_bulan()
    {
        $data = [
            '01'    => 'Januari',
            '02'    => 'Februari',
            '03'    => 'Maret',
            '04'    => 'April',
            '05'    => 'Mei',
            '06'    => 'Juni',
            '07'    => 'Juli',
            '08'    => 'Agustus',
            '09'    => 'September',
            '10'    => 'Oktober',
            '11'    => 'November',
            '12'    => 'Desember'
        ];

        return $data;
    }
}
