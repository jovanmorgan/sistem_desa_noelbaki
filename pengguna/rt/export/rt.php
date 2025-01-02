<?php include '../fitur/nama_halaman.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head_export.php'; ?>

<body translate="no">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h3 class="text-center">Data Export <?= $page_title ?> </h3>
                    </div>
                    <?php
                    include '../../../keamanan/koneksi.php';

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

                    <div class="card-body">
                        <div class="table-responsive">

                            <?php if ($result->num_rows > 0): ?>
                                <table id="example" class="table table-hover text-center mt-3"
                                    style="border-collapse: separate; border-spacing: 0;">
                                    <thead>
                                        <tr>
                                            <th style="white-space: nowrap;">
                                                Nomor</th>
                                            <th style="white-space: nowrap;">
                                                Nama RT</th>
                                            <th style="white-space: nowrap;">
                                                Nama Lengkap</th>
                                            <th style="white-space: nowrap;">
                                                Username</th>
                                            <th style="white-space: nowrap;">
                                                Password</th>
                                            <th style="white-space: nowrap;">
                                                Jenis Kelamin</th>
                                            <th style="white-space: nowrap;">
                                                Alamat</th>
                                            <th style="white-space: nowrap;">
                                                Jabatan</th>
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
                                                    <span class="badge badge-sm bg-gradient-success" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Klik untuk menyalin"
                                                        style="cursor: pointer;"
                                                        onclick="copyToClipboard('<?php echo htmlspecialchars($row['username']); ?>', this)">
                                                        <?php echo htmlspecialchars($row['username']); ?>
                                                    </span>
                                                </td>

                                                <!-- Password -->
                                                <td class="align-middle text-center">
                                                    <span class="badge badge-sm bg-gradient-success" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Klik untuk menyalin"
                                                        style="cursor: pointer;"
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
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>

                            <?php else: ?>
                                <p class="text-center mt-4">Data tidak ditemukan 😖.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>

    <?php include '../fitur/js_export.php'; ?>

</body>

</html>