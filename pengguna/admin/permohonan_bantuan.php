<?php include 'fitur/penggunah.php'; ?>

<!DOCTYPE html>
<html lang="en">

<?php include 'fitur/head.php'; ?>

<?php include 'fitur/nama_halaman.php'; ?>
<?php include 'fitur/nama_halaman_proses.php'; ?>

<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-gradient-warning position-absolute w-100"></div>

    <!-- sidebar -->
    <?php include 'fitur/sidebar.php'; ?>

    <main class="main-content position-relative border-radius-lg ">

        <!-- Navbar -->
        <?php include 'fitur/navbar.php'; ?>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">

                <div class="col-12">
                    <div class="card mb-4">
                        <!-- Konten Utama -->
                        <div class="card-body px-3 pt-3 pb-2">
                            <!-- Header dengan kata sambutan -->
                            <div class="card-header pb-0 text-center">
                                <h4>Selamat Datang!</h4>
                                <p class="text-sm">Berikut adalah tabel <?= htmlspecialchars($page_title) ?> data yang
                                    dapat Anda kelola. Gunakan fitur
                                    pencarian untuk menemukan data dengan cepat, atau tambahkan data baru menggunakan
                                    tombol di bawah.
                                </p>
                            </div>

                            <form method="GET" action="">
                                <div class="input-group">
                                    <!-- Input pencarian -->
                                    <input type="text" class="form-control"
                                        placeholder="Cari Data <?= htmlspecialchars($page_title) ?>..." name="search"
                                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                                        style="height: 50px;">
                                    <!-- Tombol pencarian -->
                                    <button class="btn btn-outline-secondary" type="submit"
                                        style="height: 50px;">Cari</button>
                                </div>
                            </form>

                            <!-- Tombol Tambah dan Ekspor -->
                            <!-- <div class="d-flex justify-content-center mt-3">
                                <button class="btn btn-success me-2" data-bs-toggle="modal"
                                    data-bs-target="#tambahDataModal">Tambah Data</button>
                            </div> -->
                        </div>
                    </div>
                </div>

                <?php
                include '../../keamanan/koneksi.php';

                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 10;
                $offset = ($page - 1) * $limit;

                // Query untuk mendapatkan data permohonan_bantuan dengan relasi
                $query = "
    SELECT 
        pb.id_permohonan_bantuan,
        pb.jenis_bantuan,
        pb.status_validasi,
        rt.nama_rt,
        kk.nama_lengkap AS nama_kepala_keluarga,
        kk.nomor_induk_kartu_keluarga,
        kkm.id_kkm,
        kkm.foto_rumah,
        kkm.foto_keluarga,
        kkm.pemasukan_perbulan
    FROM permohonan_bantuan pb
    JOIN rt ON pb.id_rt = rt.id_rt
    JOIN kepala_keluarga kk ON pb.id_kepala_keluarga = kk.id_kepala_keluarga
    JOIN keluarga_kurang_mampu kkm ON pb.id_kkm = kkm.id_kkm
    WHERE rt.nama_rt LIKE ? OR kk.nama_lengkap LIKE ?
    LIMIT ?, ?
";
                $stmt = $koneksi->prepare($query);
                $search_param = '%' . $search . '%';
                $stmt->bind_param("ssii", $search_param, $search_param, $offset, $limit);
                $stmt->execute();
                $result = $stmt->get_result();

                // Hitung total halaman
                $total_query = "
    SELECT COUNT(*) as total
    FROM permohonan_bantuan pb
    JOIN rt ON pb.id_rt = rt.id_rt
    JOIN kepala_keluarga kk ON pb.id_kepala_keluarga = kk.id_kepala_keluarga
    JOIN keluarga_kurang_mampu kkm ON pb.id_kkm = kkm.id_kkm
    WHERE rt.nama_rt LIKE ? OR kk.nama_lengkap LIKE ?
";
                $stmt_total = $koneksi->prepare($total_query);
                $stmt_total->bind_param("ss", $search_param, $search_param);
                $stmt_total->execute();
                $total_result = $stmt_total->get_result();
                $total_row = $total_result->fetch_assoc();
                $total_pages = ceil($total_row['total'] / $limit);
                ?>

                <div class="col-12" id="load_data">
                    <div class="card mb-4">
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <?php if ($result->num_rows > 0): ?>
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama RT</th>
                                                <th class="text-center">Kepala Keluarga</th>
                                                <th class="text-center">NIKK</th>
                                                <th class="text-center">Foto Rumah</th>
                                                <th class="text-center">Foto Keluarga</th>
                                                <th class="text-center">Pemasukan Per Bulan</th>
                                                <th class="text-center">Jenis Bantuan</th>
                                                <th class="text-center">Status Validasi</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $nomor = $offset + 1;
                                            while ($row = $result->fetch_assoc()) :
                                            ?>
                                                <tr>
                                                    <td class="align-middle text-center"><?php echo $nomor++; ?></td>
                                                    <td class="align-middle text-center"> RT :
                                                        <?php echo htmlspecialchars($row['nama_rt']); ?></td>
                                                    <td class="align-middle text-center">
                                                        <?php echo htmlspecialchars($row['nama_kepala_keluarga']); ?></td>
                                                    <td class="align-middle text-center">
                                                        <?php echo htmlspecialchars($row['nomor_induk_kartu_keluarga']); ?></td>
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
                                                        <?php
                                                        $pemasukan_options = [
                                                            "Kurang Dari 500000" => "Kurang dari Rp 500.000",
                                                            "500000-1000000" => "Rp 500.000 - Rp 1.000.000",
                                                            "1000000-2000000" => "Rp 1.000.000 - Rp 2.000.000",
                                                            "2000000-3000000" => "Rp 2.000.000 - Rp 3.000.000",
                                                            "3000000-5000000" => "Rp 3.000.000 - Rp 5.000.000",
                                                            "5000000-10000000" => "Rp 5.000.000 - Rp 10.000.000",
                                                            "Lebih Dari 10000000" => "Lebih dari Rp 10.000.000"
                                                        ];
                                                        echo $pemasukan_options[$row['pemasukan_perbulan']] ?? "Data tidak valid";
                                                        ?>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <?php echo htmlspecialchars($row['jenis_bantuan']); ?></td>
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
                                                        <form action="export/permohonan_bantuan" method="GET"
                                                            style="display: inline-block;" target="_blank">
                                                            <input type="hidden" name="id_permohonan_bantuan"
                                                                value="<?php echo $row['id_permohonan_bantuan']; ?>">
                                                            <button type="submit" class="btn btn-warning btn-sm m-1">Cetak
                                                                PDF</button>
                                                        </form>
                                                        <button class="btn btn-success btn-sm mt-3"
                                                            onclick="openEditModal('<?php echo $row['id_permohonan_bantuan']; ?>')">Validasi
                                                            Status</button>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p class="text-center mt-4">Data tidak ditemukan 🗂️.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="card mb-4">
                        <!-- Konten Utama -->
                        <div class="card-body px-3 pt-3 pb-2">
                            <!-- Pagination -->
                            <nav>
                                <ul class="pagination justify-content-center ">
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                            <a class="page-link text-white"
                                                href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer -->
            <?php include_once 'fitur/footer.php'; ?>
        </div>
    </main>

    <!-- awal pop Up -->

    <div class="modal-pop-up" style="z-index: 100">
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

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel">Validasi Status</h5>
                        <button type="button" class="btn-close text-dark" id="closeEditModal" data-bs-dismiss="modal"
                            aria-label="Close"> <i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" action="proses/<?= $page_title_proses ?>/edit.php"
                            enctype="multipart/form-data">
                            <input type="hidden" id="edit_id" name="id_permohonan_bantuan">

                            <!-- Status Validasi -->
                            <div class="mb-3">

                                <!-- Tombol Pilihan Status Validasi -->
                                <button type="button" class="btn btn-status btn-dalam-proses"
                                    data-status="Dalam Proses">Dalam Proses</button>
                                <button type="button" class="btn btn-status btn-disetujui"
                                    data-status="Disetujui">Disetujui</button>
                                <button type="button" class="btn btn-status btn-tidak-disetujui"
                                    data-status="Tidak Disetujui">Tidak Disetujui</button>
                            </div>

                            <!-- Hidden Input untuk Menyimpan Status -->
                            <input type="hidden" id="status_validasi_input" name="status_validasi" value="">

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <style>
            /* Gaya untuk tombol status */
            .btn-status {
                padding: 10px 20px;
                margin: 5px;
                border-radius: 25px;
                border: none;
                font-weight: bold;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .btn-status:hover {
                transform: scale(1.1);
            }

            .btn-dalam-proses {
                background-color: #f0ad4e;
                color: white;
            }

            .btn-dalam-proses.selected {
                background-color: #ec971f;
            }

            .btn-disetujui {
                background-color: #5bc0de;
                color: white;
            }

            .btn-disetujui.selected {
                background-color: #31b0d5;
            }

            .btn-tidak-disetujui {
                background-color: #d9534f;
                color: white;
            }

            .btn-tidak-disetujui.selected {
                background-color: #c9302c;
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const statusButtons = document.querySelectorAll('.btn-status');
                const statusInput = document.getElementById('status_validasi_input');

                statusButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Menghapus kelas 'selected' dari semua tombol
                        statusButtons.forEach(btn => btn.classList.remove('selected'));

                        // Menambahkan kelas 'selected' pada tombol yang dipilih
                        this.classList.add('selected');

                        // Menyimpan status yang dipilih ke input hidden
                        statusInput.value = this.getAttribute('data-status');
                    });
                });
            });
        </script>
    </div>

    </div>

    <script>
        function openEditModal(id) {
            // Inisialisasi Modal
            let editModal = new bootstrap.Modal(document.getElementById('editModal'), {});

            // Mengisi nilai input dengan data yang diterima
            document.getElementById('edit_id').value = id;

            // Menampilkan Modal
            editModal.show();
        }
    </script>

    <!-- akhir pop up -->
    <?php include_once 'fitur/js.php'; ?>
</body>

</html>

</html>