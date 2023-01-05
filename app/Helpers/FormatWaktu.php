<?php

namespace App\Helpers;

use Carbon\Carbon;

class FormatWaktu
{
    public static function tanggalIndonesia($date)
    {
        $tglIndo = Carbon::parse($date)->locale('id');
        $tglIndo->settings(['formatFunction' => 'translatedFormat']);
        return $tglIndo->format('j F Y');
    }
}
