<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Data</title>
    <link href="../../Font-Awesome/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../bootstrap/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../../assets/img-umum/umum/logo.png" type="" />
    <style>
    body {
        background-color: #f8f9fa;
    }

    .back-btn {
        background-color: #007bff;
        color: #fff;
        border-radius: 30px;
        padding: 10px 20px;
        display: inline-block;
        margin-bottom: 20px;
        text-decoration: none;
    }

    .back-btn:hover {
        background-color: #0056b3;
        color: #fff;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .table th,
    .table td {
        vertical-align: middle;
        white-space: nowrap;
    }

    .table th {
        /* text-transform: uppercase; */
        white-space: nowrap;
    }
    </style>
</head>

<body>

    <div class="container my-4">
        <!-- Tombol Kembali -->
        <a href="bantuan" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali ke Halaman Bantuan
        </a>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <!-- Konten Utama -->
                    <div class="card-body px-3 pt-3 pb-2">
                        <!-- Header dengan kata sambutan -->
                        <div class="card-header pb-0 text-center">
                            <h4>Keluarga Kurang Mampu</h4>
                            <p class="text-sm">
                                Gunakan fitur pencarian untuk menemukan data dengan cepat, dengan cara masukkan NIK,
                                NIKK, atau Nama Kepala Keluarga untuk menemukan data Anda.
                            </p>
                        </div>

                        <form method="GET" action="">
                            <div class="input-group">
                                <!-- Input pencarian -->
                                <input type="text" class="form-control" placeholder="Cari Data Keluarga Kurang Mampu..."
                                    name="search"
                                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                                    style="height: 50px;">
                                <!-- Tombol pencarian -->
                                <button class="btn btn-outline-secondary" type="submit"
                                    style="height: 50px;">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php
            include '../../keamanan/koneksi.php';

            $search = isset($_GET['search']) ? trim($_GET['search']) : '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Menambahkan pengecekan untuk memastikan panjang pencarian minimal 16 karakter
            if (!empty($search) && strlen($search) >= 16) {
                // Query untuk mendapatkan data keluarga_kurang_mampu dengan relasi
                $query = "
            SELECT 
                kkm.id_kkm,
                kkm.id_rt,
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
            JOIN rt ON kkm.id_rt = rt.id_rt
            JOIN kepala_keluarga kk ON kkm.id_kepala_keluarga = kk.id_kepala_keluarga
            WHERE kk.nomor_induk_kartu_keluarga LIKE ? OR kk.nama_lengkap LIKE ? OR kk.nik_kepala_keluarga LIKE ?
            LIMIT ?, ?
        ";
                $stmt = $koneksi->prepare($query);
                $search_param = '%' . $search . '%';
                $stmt->bind_param("sssii", $search_param, $search_param, $search_param, $offset, $limit);
                $stmt->execute();
                $result = $stmt->get_result();
            }
            ?>

            <div class="col-12" id="load_data">
                <div class="card mb-4">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <?php if (empty($search)): ?>
                            <p class="text-center mt-4">Cari dan temukan data Anda 🔍.</p>
                            <?php elseif (strlen($search) < 16): ?>
                            <p class="text-center mt-4">Data yang anda masukan belum lengkap, Silakan periksa ulang data
                                tersebut 🗃️?.</p>
                            <?php elseif ($result->num_rows > 0): ?>
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama RT
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kepala Keluarga
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            NIKK
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Foto Rumah
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Foto Keluarga
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Pemasukan Per Bulan
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status Validasi
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $nomor = $offset + 1;
                                        while ($row = $result->fetch_assoc()):
                                        ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold"><?php echo $nomor++; ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">RT
                                                :<?php echo htmlspecialchars($row['nama_rt']); ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['nama_kepala_keluarga']); ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['nomor_induk_kartu_keluarga']); ?></span>
                                        </td>
                                        <td class="align-middle text-center" style="cursor: pointer">
                                            <img src="../../assets/img-umum/konten/<?php echo htmlspecialchars($row['foto_rumah']); ?>"
                                                alt="Foto Rumah" style="width: 80px; height: auto;"
                                                onclick="openImageModal('../../assets/img-umum/konten/<?php echo htmlspecialchars($row['foto_rumah']); ?>')">
                                        </td>
                                        <td class="align-middle text-center" style="cursor: pointer">
                                            <img src="../../assets/img-umum/konten/<?php echo htmlspecialchars($row['foto_keluarga']); ?>"
                                                alt="Foto Keluarga" style="width: 80px; height: auto;"
                                                onclick="openImageModal('../../assets/img-umum/konten/<?php echo htmlspecialchars($row['foto_keluarga']); ?>')">
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <?php
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

                                                        // Menampilkan data dengan pemetaan
                                                        echo isset($pemasukan_options[$row['pemasukan_perbulan']])
                                                            ? $pemasukan_options[$row['pemasukan_perbulan']]
                                                            : "Data tidak valid";
                                                        ?>
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge 
                                                <?php
                                                if ($row['status_validasi'] == 'Disetujui') {
                                                    echo 'bg-success'; // Hijau untuk Disetujui
                                                } elseif ($row['status_validasi'] == 'Tidak Disetujui') {
                                                    echo 'bg-danger'; // Merah untuk Tidak Disetujui
                                                } elseif ($row['status_validasi'] == 'Dalam Proses') {
                                                    echo 'bg-primary'; // Biru untuk Dalam Proses
                                                }
                                                ?>">
                                                <?php echo htmlspecialchars($row['status_validasi']); ?>
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <form action="export/kkm" method="GET" style="display: inline-block;"
                                                target="_blank">
                                                <input type="hidden" name="id_kkm"
                                                    value="<?php echo $row['id_kkm']; ?>">
                                                <button type="submit" class="btn btn-warning btn-sm m-1">Cetak
                                                    PDF</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                            <p class="text-center mt-4">Mohon maaf, Keluarga Anda tidak terdaftar sebagai Keluarga
                                Kurang Mampu 🗂️.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script>
    function openImageModal(imageSrc) {
        // Set the image source in the modal
        document.getElementById('modalImage').src = imageSrc;

        // Initialize and show the modal
        let imageModal = new bootstrap.Modal(document.getElementById('imageModal'), {});
        imageModal.show();
    }
    </script>


    <!-- Modal Image Viewer -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Gambar" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <script src="../bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
</div>
</div>

<script src="../bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>