<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page_proses = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Tentukan judul halaman berdasarkan nama file
switch ($current_page_proses) {
    case 'dashboard':
        $page_title_proses = 'dashboard';
        break;
    case 'anggota_keluarga':
        $page_title_proses = 'anggota_keluarga';
        break;
    case 'kkm':
        $page_title_proses = 'kkm';
        break;
    case 'validasi_kkm':
        $page_title_proses = 'vkkm';
        break;
    case 'kepala_keluarga':
        $page_title_proses = 'kepala_keluarga';
        break;
    case 'permohonan_bantuan':
        $page_title_proses = 'permohonan_bantuan';
        break;
    case 'pimpinan':
        $page_title_proses = 'pimpinan';
        break;
    case 'rt':
        $page_title_proses = 'rt';
        break;
    case 'kontak':
        $page_title_proses = 'kontak';
        break;
    case 'profile':
        $page_title_proses = 'profile';
        break;
    case 'log_out':
        $page_title_proses = 'log_out';
        break;
    default:
        $page_title_proses = 'Admin Gereja ';
        break;
}
