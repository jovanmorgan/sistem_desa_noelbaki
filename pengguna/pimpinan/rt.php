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
                                <a class="btn btn-outline-primary" target="_blank"
                                    href="export/<?= htmlspecialchars($page_title_proses) ?>">Ekspor Data</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- logika tabel -->
                <?php
                include '../../keamanan/koneksi.php';

                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 10;
                $offset = ($page - 1) * $limit;

                // Query untuk mendapatkan data rt dengan pencarian dan pagination
                $query = "
                                SELECT * 
                                FROM rt 
                                WHERE jenis_kelamin LIKE ? OR nama_lengkap LIKE ? OR alamat LIKE ? OR username LIKE ?  OR password LIKE ?  OR fp LIKE ?  OR jabatan LIKE ?  OR nama_rt LIKE ?
                                LIMIT ?, ?
                            ";
                $stmt = $koneksi->prepare($query);
                $search_param = '%' . $search . '%';
                $stmt->bind_param("ssssssssii", $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $offset, $limit);
                $stmt->execute();
                $result = $stmt->get_result();

                // Hitung total halaman
                $total_query = "
                                SELECT COUNT(*) as total 
                                FROM rt 
                                WHERE jenis_kelamin LIKE ? OR nama_lengkap LIKE ? OR alamat LIKE ? OR username LIKE ?  OR password LIKE ?  OR fp LIKE ?  OR jabatan LIKE ?  OR nama_rt LIKE ? 
                            ";
                $stmt_total = $koneksi->prepare($total_query);
                $stmt_total->bind_param("ssssssss", $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param);
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
                                                    Nomor</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nama RT</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nama Lengkap</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Username</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Password</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Jenis Kelamin</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Alamat</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Jabatan</th>
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
                                                        <span class="text-secondary text-xs font-weight-bold">RT :
                                                            <?php echo htmlspecialchars($row['nama_rt']); ?></span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['nama_lengkap']); ?></span>
                                                    </td>
                                                    <!-- Username -->
                                                    <td class="align-middle text-center">
                                                        <span class="badge badge-sm bg-gradient-success"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Klik untuk menyalin" style="cursor: pointer;"
                                                            onclick="copyToClipboard('<?php echo htmlspecialchars($row['username']); ?>', this)">
                                                            <?php echo htmlspecialchars($row['username']); ?>
                                                        </span>
                                                    </td>

                                                    <!-- Password -->
                                                    <td class="align-middle text-center">
                                                        <span class="badge badge-sm bg-gradient-success"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Klik untuk menyalin" style="cursor: pointer;"
                                                            onclick="copyToClipboard('<?php echo htmlspecialchars($row['password']); ?>', this)">
                                                            <?php echo htmlspecialchars($row['password']); ?>
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['jenis_kelamin']); ?></span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['alamat']); ?></span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['jabatan']); ?></span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <button class="btn btn-primary btn-sm mt-3"
                                                            onclick="openEditModal('<?php echo $row['id_rt']; ?>','<?php echo $row['nama_rt']; ?>','<?php echo $row['nama_lengkap']; ?>', '<?php echo $row['jenis_kelamin']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['password']; ?>', '<?php echo $row['alamat']; ?>', '<?php echo $row['jabatan']; ?>')">Edit</button>
                                                        <button class="btn btn-danger btn-sm mt-3"
                                                            onclick="hapus('<?php echo $row['id_rt']; ?>')">Hapus</button>
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
                            <!-- Nama rt -->
                            <div class="mb-3">
                                <label for="nama_rt" class="form-label">Nama RT</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="number" min="0" id="nama_rt" name="nama_rt" class="form-control"
                                        placeholder="Masukkan nama rt" required>
                                </div>
                            </div>
                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                                        <option value="" disabled selected>Pilih jenis kelamin</option>
                                        <option value="pria">Pria</option>
                                        <option value="wanita">Wanita</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                    <input type="text" id="username" name="username" class="form-control"
                                        placeholder="Masukkan username" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="text" id="password" name="password" class="form-control"
                                        placeholder="Masukkan password" required>
                                </div>
                            </div>

                            <!-- jabatan -->
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                    <select class="form-select" name="jabatan" id="jabatan" required>
                                        <option value="" disabled selected>Pilih Jabatan</option>
                                        <option value="Ketua RT">Ketua RT</option>
                                        <option value="Wakil Ketua RT">Wakil Ketua RT</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="alamat">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3"
                                        placeholder="Masukkan alamat" required></textarea>
                                </div>
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
                            <input type="hidden" id="edit_id" name="id_rt">

                            <!-- Nama rt -->
                            <div class="mb-3">
                                <label for="nama_rt" class="form-label">Nama RT</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="number" min="0" id="edit_nama_rt" name="nama_rt" class="form-control"
                                        placeholder="Masukkan nama rt" required>
                                </div>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" id="edit_nama_lengkap" name="nama_lengkap" class="form-control"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    <select class="form-select" name="jenis_kelamin" id="edit_jenis_kelamin" required>
                                        <option value="" disabled selected>Pilih jenis kelamin</option>
                                        <option value="pria">Pria</option>
                                        <option value="wanita">Wanita</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                    <input type="text" id="edit_username" name="username" class="form-control"
                                        placeholder="Masukkan username" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="text" id="edit_password" name="password" class="form-control"
                                        placeholder="Masukkan password" required>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="alamat">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea class="form-control" id="edit_alamat" name="alamat" rows="3"
                                        placeholder="Masukkan alamat" required></textarea>
                                </div>
                            </div>

                            <!-- jabatan -->
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                    <select class="form-select" name="jabatan" id="edit_jabatan" required>
                                        <option value="" disabled selected>Pilih Jabatan</option>
                                        <option value="Ketua RT">Ketua RT</option>
                                        <option value="Wakil Ketua RT">Wakil Ketua RT</option>
                                    </select>
                                </div>
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
        function openEditModal(id, nama_rt, nama_lengkap, jenis_kelamin, username, password, alamat, jabatan) {
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama_rt').value = nama_rt;
            document.getElementById('edit_nama_lengkap').value = nama_lengkap;
            document.getElementById('edit_jenis_kelamin').value = jenis_kelamin;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_password').value = password;
            document.getElementById('edit_alamat').value = alamat;
            document.getElementById('edit_jabatan').value = jabatan;
            editModal.show();
        }
    </script>

    <?php include_once 'fitur/js.php'; ?>
</body>

</html>

</html>