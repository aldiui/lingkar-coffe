<?php

use Carbon\Carbon;

if (!function_exists('formatTanggal')) {
    function formatTanggal($tanggal = null, $format = 'l, j F Y')
    {
        $parsedDate = Carbon::parse($tanggal)->locale('id')->settings(['formatFunction' => 'translatedFormat']);
        return $parsedDate->format($format);
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('statusBadge')) {
    function statusBadge($status)
    {
        $statusIcon = ($status == '0') ? '<i class="fas fa-clock me-1"></i>' : (($status == '1') ? '<i class="fas fa-check-circle me-1"></i>' : '<i class="fas fa-times-circle me-1"></i>');
        $statusClass = ($status == '0') ? 'bg-warning' : (($status == '1') ? 'bg-success' : 'bg-danger');
        $statusText = ($status == '0') ? 'Menunggu' : (($status == '1') ? 'Disetujui' : 'Ditolak');

        return "<span class='badge d-inline-flex align-items-baseline $statusClass'>$statusIcon $statusText</span>";
    }
}

if (!function_exists('bulan')) {
    function bulan()
    {
        return [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
    }
}
