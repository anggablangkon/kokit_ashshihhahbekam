<?php

// if (!function_exists('greet')) {
//     function greet($name)
//     {
//         return "Halo, {$name}!";
//     }
// }

use Carbon\Carbon;

function rupiah($angka)
{
    return 'Rp,' . number_format($angka, 0, ',', '.');
}
function angka($angka)
{
    return number_format($angka, 0, ',', '.');
}

// function un_angka($angka)
// {
//     return (int) str_replace(['.', ','], '', $angka);
// }

function tglindo($val)
{
    return Carbon::parse($val)->translatedFormat('j F Y');
}


function tglindojam($val)
{
    return Carbon::parse($val)->translatedFormat('j F Y H:i:s');
}

function tglindojammenit($val)
{
    return Carbon::parse($val)->translatedFormat('j F Y H:i');
}

function percentage($program)
{
    $percentage = $program->target_amount > 0 ? round(($program->raised_amount / $program->target_amount) * 100) : 0;
    return $percentage;
}

function daysLeft($program)
{

    $end_date = $program->end_date;
    $now = date('Y-m-d'); // tanggal hari ini, format Y-m-d
    $date1 = new DateTime($end_date);
    $date2 = new DateTime($now);
    // Hitung selisih interval
    $diff = $date1->diff($date2);
    // Dapatkan selisih hari (integer)
    $daysLeft = (int) $diff->format('%a');
    return $daysLeft;
}
