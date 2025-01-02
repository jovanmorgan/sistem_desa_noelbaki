<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Tentukan judul halaman berdasarkan nama file
switch ($current_page) {
    case 'dashboard':
        $page_title = 'Dashboard';
        break;
    case 'anggota_keluarga':
        $page_title = 'Anggota Keluarga';
        break;
    case 'kkm':
        $page_title = 'Keluarga Kurang Mampu';
        break;
    case 'kepala_keluarga':
        $page_title = 'Kepala Keluarga';
        break;
    case 'permohonan_bantuan':
        $page_title = 'Permohonan Bantuan';
        break;
    case 'pimpinan':
        $page_title = 'Pimpinan';
        break;
    case 'rt':
        $page_title = 'Rukun Warga';
        break;
    case 'validasi_kkm':
        $page_title = 'Validasi Keluarga Kurang Mampu';
        break;
    case 'kontak':
        $page_title = 'Kontak';
        break;
    case 'profile':
        $page_title = 'Profile Saya';
        break;
    case 'log_out':
        $page_title = 'Log Out';
        break;
    default:
        $page_title = 'Admin Gereja ';
        break;
}
