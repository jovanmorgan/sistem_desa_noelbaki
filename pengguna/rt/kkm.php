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
                            <div class="d-flex justify-content-center mt-3">
                                <button class="btn btn-success me-2" data-bs-toggle="modal"
                                    data-bs-target="#tambahDataModal">Tambah Data</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                include '../../keamanan/koneksi.php';

                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 10;
                $offset = ($page - 1) * $limit;

                // Query untuk mendapatkan data keluarga_kurang_mampu dengan relasi
                $query = "
    SELECT 
        kkm.id_kkm,
        kkm.id_rt,
        kkm.id_kepala_keluarga,
        rt.nama_rt,
        kk.nama_lengkap AS nama_kepala_keluarga,
        kk.nomor_induk_kartu_keluarga,
        kkm.foto_rumah,
        kkm.foto_keluarga,
        kkm.pemasukan_perbulan,
        kkm.status_validasi
    FROM keluarga_kurang_mampu kkm
    JOIN rt ON kkm.id_rt = rt.id_rt
    JOIN kepala_keluarga kk ON kkm.id_kepala_keluarga = kk.id_kepala_keluarga
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
    FROM keluarga_kurang_mampu kkm
    JOIN rt ON kkm.id_rt = rt.id_rt
    JOIN anggota_keluarga kk ON kkm.id_kepala_keluarga = kk.id_kepala_keluarga
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
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama RT</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Kepala Keluarga</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                NIKK</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Foto Rumah</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Foto Keluarga</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Pemasukan Per Bulan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status Validasi</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $nomor = $offset + 1;
                                            while ($row = $result->fetch_assoc()) :
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
                                                <form action="export/kkm" target="_blank" method="GET"
                                                    style="display: inline-block;">
                                                    <input type="hidden" name="id_kkm"
                                                        value="<?php echo $row['id_kkm']; ?>">
                                                    <button type="submit" class="btn btn-warning btn-sm m-1">Cetak
                                                        PDF</button>
                                                </form>
                                                <button class="btn btn-primary btn-sm mt-3"
                                                    onclick="openEditModal(<?php echo $row['id_kkm']; ?>, '<?php echo $row['id_rt']; ?>', '<?php echo $row['id_kepala_keluarga']; ?>', '<?php echo $row['foto_rumah']; ?>', '<?php echo $row['foto_keluarga']; ?>', '<?php echo $row['pemasukan_perbulan']; ?>')">Edit</button>
                                                <button class="btn btn-danger btn-sm mt-3"
                                                    onclick="hapus(<?php echo $row['id_kkm']; ?>)">Hapus</button>
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

        <!-- Modal -->
        <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDataModalLabel">Tambah <?= $page_title ?></h5>
                        <button type="button" class="btn-close text-dark" id="closeTambahModal" data-bs-dismiss="modal"
                            aria-label="Close"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form id="tambahForm" method="POST" action="proses/<?= $page_title_proses ?>/tambah.php"
                            enctype="multipart/form-data">
                            <input type="hidden" name="id_rt" value="<?php echo $id_rt; ?>" id="id_rt">

                            <!-- Select Kepala Keluarga -->
                            <div class="mb-3">
                                <label for="id_kepala_keluarga" class="form-label">
                                    Kepala Keluarga
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                    <select class="form-select" id="id_kepala_keluarga" name="id_kepala_keluarga"
                                        required>
                                        <option value="">Pilih Kepala Keluarga</option>
                                        <?php
                                        $query = "SELECT * FROM kepala_keluarga WHERE id_rt = '$id_rt'";
                                        $result = $koneksi->query($query);
                                        while ($row = $result->fetch_assoc()): ?>
                                        <option value="<?php echo $row['id_kepala_keluarga']; ?>">
                                            <?php echo $row['nama_lengkap']; ?> (NIKK :
                                            <?php echo $row['nomor_induk_kartu_keluarga']; ?>)
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Input Foto Rumah -->
                            <div class="form-group">
                                <label for="kover">Foto Rumah:</label>
                                <input type="file" class="form-control-file d-none" id="kover" name="foto_rumah"
                                    onchange="previewImage(this, 'koverPreview')" accept="image/*">
                                <label class="btn btn-primary text-white" for="kover">
                                    <i class="fas fa-home"></i> Pilih Foto Rumah
                                </label>
                            </div>
                            <div class="card mt-2" id="koverPreview" style="display: none;">
                                <img class="card-img-top" id="koverImage" src="#" alt="Kover Image">
                            </div>

                            <!-- Input Foto Keluarga -->
                            <div class="form-group mt-2">
                                <label for="foto_keluarga">Foto Keluarga:</label>
                                <input type="file" class="form-control-file d-none" id="foto_keluarga"
                                    name="foto_keluarga" onchange="previewImage(this, 'keluargaPreview')"
                                    accept="image/*">
                                <label class="btn btn-success text-white" for="foto_keluarga">
                                    <i class="fas fa-users"></i> Pilih Foto Keluarga
                                </label>
                            </div>
                            <div class="card mt-2" id="keluargaPreview" style="display: none;">
                                <img class="card-img-top" id="keluargaImage" src="#" alt="Keluarga Image">
                            </div>

                            <!-- Pemasukan Per Bulan -->
                            <label for="pemasukan_perbulan" class="form-label">
                                Pemasukan Per Bulan:
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                <select name="pemasukan_perbulan" id="pemasukan_perbulan" class="form-select" required>
                                    <option value="">-- Pilih Pemasukan --</option>
                                    <option value="Kurang Dari 500000">Kurang dari Rp 500.000</option>
                                    <option value="500000-1000000">Rp 500.000 - Rp 1.000.000</option>
                                    <option value="1000000-2000000">Rp 1.000.000 - Rp 2.000.000</option>
                                    <option value="2000000-3000000">Rp 2.000.000 - Rp 3.000.000</option>
                                    <option value="3000000-5000000">Rp 3.000.000 - Rp 5.000.000</option>
                                    <option value="5000000-10000000">Rp 5.000.000 - Rp 10.000.000</option>
                                    <option value="Lebih Dari 10000000">Lebih dari Rp 10.000.000</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function previewImage(input, previewId) {
            var preview = document.getElementById(previewId);
            var image = preview.querySelector('img');
            var file = input.files[0];

            if (file && file.type.match('image.*')) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    image.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                image.src = '#';
                preview.style.display = 'none';
            }
        }
        </script>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel">Edit <?= $page_title ?></h5>
                        <button type="button" class="btn-close text-dark" id="closeEditModal" data-bs-dismiss="modal"
                            aria-label="Close"> <i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" action="proses/<?= $page_title_proses ?>/edit.php"
                            enctype="multipart/form-data">
                            <input type="hidden" id="edit_id" name="id_kkm">
                            <input type="hidden" id="edit_id_rt" name="id_rt">

                            <!-- Select Kepala Keluarga -->
                            <div class="mb-3">
                                <label for="id_kepala_keluarga" class="form-label">
                                    Kepala Keluarga
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                    <select class="form-select" id="edit_id_kepala_keluarga" name="id_kepala_keluarga"
                                        required>
                                        <option value="">Pilih Kepala Keluarga</option>
                                        <?php
                                        $query = "SELECT * FROM kepala_keluarga WHERE id_rt = '$id_rt'";
                                        $result = $koneksi->query($query);
                                        while ($row = $result->fetch_assoc()): ?>
                                        <option value="<?php echo $row['id_kepala_keluarga']; ?>">
                                            <?php echo $row['nama_lengkap']; ?> (NIKK :
                                            <?php echo $row['nomor_induk_kartu_keluarga']; ?>)
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Input Foto Rumah -->
                            <div class="form-group">
                                <label for="kover">Foto Rumah:</label>
                                <input type="file" class="form-control-file d-none" id="edit_kover" name="foto_rumah"
                                    onchange="previewImage(this, 'koverPreview')" accept="image/*">
                                <label class="btn btn-primary text-white" for="kover">
                                    <i class="fas fa-home"></i> Pilih Foto Rumah
                                </label>
                            </div>
                            <div class="card mt-2" id="edit_koverPreview" style="display: none;">
                                <img class="card-img-top" id="edit_koverImage" src="#" alt="Kover Image">
                            </div>

                            <!-- Input Foto Keluarga -->
                            <div class="form-group mt-2">
                                <label for="foto_keluarga">Foto Keluarga:</label>
                                <input type="file" class="form-control-file d-none" id="edit_foto_keluarga"
                                    name="foto_keluarga" onchange="previewImage(this, 'keluargaPreview')"
                                    accept="image/*">
                                <label class="btn btn-success text-white" for="foto_keluarga">
                                    <i class="fas fa-users"></i> Pilih Foto Keluarga
                                </label>
                            </div>
                            <div class="card mt-2" id="edit_keluargaPreview" style="display: none;">
                                <img class="card-img-top" id="edit_keluargaImage" src="#" alt="Keluarga Image">
                            </div>

                            <!-- Pemasukan Per Bulan -->
                            <label for="pemasukan_perbulan" class="form-label">
                                Pemasukan Per Bulan:
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                <select name="pemasukan_perbulan" id="edit_pemasukan_perbulan" class="form-select"
                                    required>
                                    <option value="">-- Pilih Pemasukan --</option>
                                    <option value="Kurang Dari 500000">Kurang dari Rp 500.000</option>
                                    <option value="500000-1000000">Rp 500.000 - Rp 1.000.000</option>
                                    <option value="1000000-2000000">Rp 1.000.000 - Rp 2.000.000</option>
                                    <option value="2000000-3000000">Rp 2.000.000 - Rp 3.000.000</option>
                                    <option value="3000000-5000000">Rp 3.000.000 - Rp 5.000.000</option>
                                    <option value="5000000-10000000">Rp 5.000.000 - Rp 10.000.000</option>
                                    <option value="Lebih Dari 10000000">Lebih dari Rp 10.000.000</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- akhir pop up -->

    <script>
    function openEditModal(id, id_rt, id_kepala_keluarga, foto_rumah, foto_keluarga, pemasukan_perbulan) {
        let editModal = new bootstrap.Modal(document.getElementById('editModal'));

        // Isi nilai pada form modal
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_id_rt').value = id_rt;
        document.getElementById('edit_id_kepala_keluarga').value = id_kepala_keluarga;

        // Foto Rumah
        if (foto_rumah) {
            let koverPreview = document.getElementById('edit_koverPreview');
            let koverImage = document.getElementById('edit_koverImage');
            koverImage.src = `../../assets/img-umum/konten/${foto_rumah}`; // Sesuaikan path ke file foto rumah
            koverPreview.style.display = 'block';
        }

        // Foto Keluarga
        if (foto_keluarga) {
            let keluargaPreview = document.getElementById('edit_keluargaPreview');
            let keluargaImage = document.getElementById('edit_keluargaImage');
            keluargaImage.src = `../../assets/img-umum/konten/${foto_keluarga}`; // Sesuaikan path ke file foto keluarga
            keluargaPreview.style.display = 'block';
        }

        // Pemasukan Per Bulan
        document.getElementById('edit_pemasukan_perbulan').value = pemasukan_perbulan;

        // Tampilkan modal
        editModal.show();
    }
    </script>


    <?php include_once 'fitur/js.php'; ?>
</body>

</html>

</html>