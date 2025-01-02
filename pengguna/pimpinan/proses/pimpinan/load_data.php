  <!-- logika tabel -->
  <?php
    include '../../../../keamanan/koneksi.php';

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Query untuk mendapatkan data pimpinan dengan pencarian dan pagination
    $query = "
                                SELECT * 
                                FROM pimpinan 
                                WHERE jenis_kelamin LIKE ? OR nama_lengkap LIKE ? OR no_telpon LIKE ? OR username LIKE ?  OR password LIKE ?  OR fp LIKE ?  OR jabatan LIKE ? 
                                LIMIT ?, ?
                            ";
    $stmt = $koneksi->prepare($query);
    $search_param = '%' . $search . '%';
    $stmt->bind_param("sssssssii", $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    // Hitung total halaman
    $total_query = "
                                SELECT COUNT(*) as total 
                                FROM pimpinan 
                                WHERE jenis_kelamin LIKE ? OR nama_lengkap LIKE ? OR no_telpon LIKE ? OR username LIKE ?  OR password LIKE ?  OR fp LIKE ?  OR jabatan LIKE ? 
                            ";
    $stmt_total = $koneksi->prepare($total_query);
    $stmt_total->bind_param("sssssss", $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param);
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
                                      Nomor Telpon</th>
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
                                          <span class="text-secondary text-xs font-weight-bold"><?php echo $nomor++; ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['nama_lengkap']); ?></span>
                                      </td>
                                      <!-- Username -->
                                      <td class="align-middle text-center">
                                          <span class="badge badge-sm bg-gradient-success" data-bs-toggle="tooltip"
                                              data-bs-placement="top" title="Klik untuk menyalin" style="cursor: pointer;"
                                              onclick="copyToClipboard('<?php echo htmlspecialchars($row['username']); ?>', this)">
                                              <?php echo htmlspecialchars($row['username']); ?>
                                          </span>
                                      </td>

                                      <!-- Password -->
                                      <td class="align-middle text-center">
                                          <span class="badge badge-sm bg-gradient-success" data-bs-toggle="tooltip"
                                              data-bs-placement="top" title="Klik untuk menyalin" style="cursor: pointer;"
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
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['no_telpon']); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <span
                                              class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($row['jabatan']); ?></span>
                                      </td>
                                      <td class="align-middle text-center">
                                          <button class="btn btn-primary btn-sm"
                                              onclick="openEditModal('<?php echo $row['id_pimpinan']; ?>','<?php echo $row['nama_lengkap']; ?>', '<?php echo $row['jenis_kelamin']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['password']; ?>', '<?php echo $row['no_telpon']; ?>', '<?php echo $row['jabatan']; ?>')">Edit</button>
                                          <button class="btn btn-danger btn-sm"
                                              onclick="hapus('<?php echo $row['id_pimpinan']; ?>')">Hapus</button>
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