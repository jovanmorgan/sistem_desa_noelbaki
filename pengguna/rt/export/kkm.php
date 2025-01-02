<?php
include '../../../keamanan/koneksi.php';

$id_kkm = isset($_GET['id_kkm']) ? $_GET['id_kkm'] : '';

// Pemetaan opsi pemasukan per bulan
$pemasukan_options = [
    "Kurang Dari 500000" => "Kurang dari Rp 500.000",
    "500000-1000000" => "Rp 500.000 - Rp 1.000.000",
    "1000000-2000000" => "Rp 1.000.000 - Rp 2.000.000",
    "2000000-3000000" => "Rp 2.000.000 - Rp 3.000.000",
    "3000000-5000000" => "Rp 3.000.000 - Rp 5.000.000",
    "5000000-10000000" => "Rp 5.000.000 - Rp 10.000.000",
    "Lebih Dari 10000000" => "Lebih dari Rp 10.000.000"
];

// Ambil data keluarga kurang mampu berdasarkan `id_kkm`
$query = "SELECT 
        kkm.id_kkm,
        kkm.id_rt,
        p.nama_lengkap AS nama_lurah,
        kkm.id_kepala_keluarga,
        rt.nama_rt,
        kk.nama_lengkap AS nama_kepala_keluarga,
        kk.nomor_induk_kartu_keluarga,
        kk.nik_kepala_keluarga,
        kkm.foto_rumah,
        kkm.foto_keluarga,
        kkm.pemasukan_perbulan,
        kkm.status_validasi
    FROM keluarga_kurang_mampu kkm
    JOIN pimpinan p ON p.id_pimpinan = 1
    JOIN rt ON kkm.id_rt = rt.id_rt
    JOIN kepala_keluarga kk ON kkm.id_kepala_keluarga = kk.id_kepala_keluarga
    WHERE kkm.id_kkm = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $id_kkm);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $dataKeluarga = $result->fetch_assoc();

    // Konversi pemasukan per bulan
    $pemasukan_per_bulan = isset($pemasukan_options[$dataKeluarga['pemasukan_perbulan']])
        ? $pemasukan_options[$dataKeluarga['pemasukan_perbulan']]
        : "Tidak diketahui";

    // Tambahkan deskripsi berdasarkan status_validasi
    $deskripsi_status = '';
    switch ($dataKeluarga['status_validasi']) {
        case 'Dalam Proses':
            $deskripsi_status = 'Laporan Keluarga Kurang Mampu sementara dalam proses. Mohon menunggu konfirmasi dari petugas administrasi.';
            break;
        case 'Disetujui':
            $deskripsi_status = 'Laporan Keluarga Kurang Mampu telah disetujui. Anda akan menerima pemberitahuan resmi dari petugas administrasi.';
            break;
        case 'Tidak Disetujui':
            $deskripsi_status = 'Laporan Keluarga Kurang Mampu tidak disetujui. Silakan menghubungi petugas administrasi untuk informasi lebih lanjut.';
            break;
        default:
            $deskripsi_status = 'Status validasi tidak diketahui. Silakan periksa kembali data Anda atau hubungi petugas administrasi.';
            break;
    }

    // Tambahkan deskripsi ke data
    $dataKeluarga['deskripsi_status'] = $deskripsi_status;


    // Hitung jumlah anggota keluarga
    $id_kepala_keluarga = $dataKeluarga['id_kepala_keluarga'];
    $queryJumlahAnggota = "SELECT COUNT(*) AS jumlah_anggota 
                           FROM anggota_keluarga 
                           WHERE id_kepala_keluarga = ?";
    $stmtJumlahAnggota = $koneksi->prepare($queryJumlahAnggota);
    $stmtJumlahAnggota->bind_param("s", $id_kepala_keluarga);
    $stmtJumlahAnggota->execute();
    $resultJumlahAnggota = $stmtJumlahAnggota->get_result();
    $jumlahAnggota = $resultJumlahAnggota->fetch_assoc()['jumlah_anggota'];

    // Tambahkan jumlah anggota keluarga ke data
    $dataKeluarga['jumlah_anggota_keluarga'] = $jumlahAnggota;
    $dataKeluarga['pemasukan_perbulan'] = $pemasukan_per_bulan;
} else {
    $dataKeluarga = [
        'nama_rt' => '............................',
        'nama_lurah' => '............................',
        'nama_kepala_keluarga' => '............................',
        'nomor_induk_kartu_keluarga' => '............................',
        'nik_kepala_keluarga' => '............................',
        'foto_rumah' => '............................',
        'foto_keluarga' => '............................',
        'pemasukan_perbulan' => '............................',
        'status_validasi' => '............................',
        'jumlah_anggota_keluarga' => '0',
        'deskripsi_status' => ''
    ];
}

// Isi placeholder pada HTML template
$templateHtml = file_get_contents('kkm.html');
$htmlContent = str_replace(
    [
        '[Nama RT]',
        '[Nama Lurah]',
        '[Kepala Keluarga]',
        '[Nomor Induk Kartu Keluarga]',
        '[NIK Kepala Keluarga]',
        '[Foto Rumah]',
        '[Foto Keluarga]',
        '[Pemasukan Per Bulan]',
        '[Status Validasi]',
        '[Jumlah Anggota Keluarga]',
        '[Tanggal Surat]',
        '[Deskripsi Status]', // Tambahkan placeholder baru
    ],
    [
        htmlspecialchars($dataKeluarga['nama_rt']),
        htmlspecialchars($dataKeluarga['nama_lurah']),
        htmlspecialchars($dataKeluarga['nama_kepala_keluarga']),
        htmlspecialchars($dataKeluarga['nomor_induk_kartu_keluarga']),
        htmlspecialchars($dataKeluarga['nik_kepala_keluarga']),
        htmlspecialchars($dataKeluarga['foto_rumah']),
        htmlspecialchars($dataKeluarga['foto_keluarga']),
        htmlspecialchars($dataKeluarga['pemasukan_perbulan']),
        htmlspecialchars($dataKeluarga['status_validasi']),
        htmlspecialchars($dataKeluarga['jumlah_anggota_keluarga']),
        date('d M Y'),
        htmlspecialchars($dataKeluarga['deskripsi_status']), // Isi placeholder baru
    ],
    $templateHtml
);

// Buat file HTML sementara
$tmpHtmlFile = tempnam(sys_get_temp_dir(), 'html') . '.html';
file_put_contents($tmpHtmlFile, $htmlContent);

// Nama file PDF output
$outputFile = sys_get_temp_dir() . '/laporan_keluarga_kurang_mampu.pdf';

// Jalankan perintah wkhtmltopdf
$command = "C:/xampp/htdocs/sistem_desa_noelbaki/wkhtmltopdf/bin/wkhtmltopdf $tmpHtmlFile $outputFile";
exec($command, $output, $return_var);

// Cek kesalahan
if ($return_var != 0) {
    echo "Gagal membuat PDF. Error: <pre>" . print_r($output, true) . "</pre>";
    unlink($tmpHtmlFile);
    exit;
}

unlink($tmpHtmlFile);

// Kirim PDF ke browser
if (file_exists($outputFile)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="laporan_keluarga_kurang_mampu.pdf"');
    header('Content-Length: ' . filesize($outputFile));
    readfile($outputFile);
} else {
    echo "File PDF tidak ditemukan.";
}
