<?php
// Daftar halaman yang tersedia
$pages = [
    '../dashboard' => 'Dashboard Home',
    '../anggota_keluarga' => 'Anggota Keluarga',
    '../kkm' => 'Keluarga Kurang Mampu',
    '../validasi_kkm' => 'Validasi Keluarga Kurang Mampu',
    '../kepala_keluarga' => 'Kepala Keluarga',
    '../permohonan_bantuan' => 'Permohonan Bantuan',
    '../pimpinan' => 'Pimpinan',
    '../rt' => 'Rukun Warga',
    '../profile' => 'Profile',
    '../log_out' => 'Log Out'
];

// Dapatkan query pencarian dari input
$query = isset($_POST['query']) ? strtolower(trim($_POST['query'])) : '';

// Variabel untuk menyimpan halaman yang cocok
$matched_page = null;

if ($query) {
    // Cari halaman yang tepat atau mendekati
    foreach ($pages as $page => $title) {
        if (strpos(strtolower($title), $query) !== false) {
            $matched_page = $page;
            break;
        }
    }

    // Redirect ke halaman yang cocok, atau ke halaman 404 jika tidak ada yang cocok
    if ($matched_page) {
        header("Location: $matched_page");
    } else {
        header("Location: ../404");
    }
    exit;
}
