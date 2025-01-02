 <div id="load_data">
     <section class="section">
         <div class="row">
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-body text-center">
                         <!-- Search Form -->
                         <form method="GET" action="">
                             <div class="input-group mt-3">
                                 <input type="text" class="form-control" placeholder="Cari Data Jemaat..." name="search"
                                     value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                 <button class="btn btn-outline-secondary" type="submit">Cari</button>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </section>

     <?php
        include '../../../../keamanan/koneksi.php';

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Query untuk mendapatkan data jemaat dengan pencarian dan pagination
        $query = "
                                SELECT jemaat.id_jemaat, jemaat.nama_lengkap AS nama_jemaat, jemaat.jenis_kelamin, jemaat.alamat, jemaat.no_hp, jemaat.status_babtis, jemaat.status_sidi, jemaat.status_nikah, 
                                    rayon.nama_rayon, rayon.id_rayon, kepala_keluarga.id_kepala_keluarga, kepala_keluarga.nama_lengkap AS nama_kepala_keluarga
                                FROM jemaat
                                INNER JOIN rayon ON jemaat.id_rayon = rayon.id_rayon
                                INNER JOIN kepala_keluarga ON jemaat.id_kepala_keluarga = kepala_keluarga.id_kepala_keluarga
                                WHERE jemaat.nama_lengkap LIKE ? OR jemaat.alamat LIKE ? OR jemaat.jenis_kelamin LIKE ? 
                                    OR rayon.nama_rayon LIKE ? OR kepala_keluarga.nama_lengkap LIKE ?
                                LIMIT ?, ?
                            ";
        $stmt = $koneksi->prepare($query);
        $search_param = '%' . $search . '%';
        $stmt->bind_param("ssssiii", $search_param, $search_param, $search_param, $search_param, $search_param, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        // Hitung total halaman
        $total_query = "
                                    SELECT COUNT(*) as total
                                    FROM jemaat
                                    INNER JOIN rayon ON jemaat.id_rayon = rayon.id_rayon
                                    INNER JOIN kepala_keluarga ON jemaat.id_kepala_keluarga = kepala_keluarga.id_kepala_keluarga
                                    WHERE jemaat.nama_lengkap LIKE ? OR jemaat.alamat LIKE ? OR jemaat.jenis_kelamin LIKE ? 
                                        OR rayon.nama_rayon LIKE ? OR kepala_keluarga.nama_lengkap LIKE ?
                                ";
        $stmt_total = $koneksi->prepare($total_query);
        $stmt_total->bind_param("sssss", $search_param, $search_param, $search_param, $search_param, $search_param);
        $stmt_total->execute();
        $total_result = $stmt_total->get_result();
        $total_row = $total_result->fetch_assoc();
        $total_pages = ceil($total_row['total'] / $limit);
        ?>

     <!-- Tabel Data Jemaat -->
     <section class="section">
         <div class="row">
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-body" style="overflow-x: hidden;">
                         <div style="overflow-x: auto;">
                             <?php if ($result->num_rows > 0): ?>
                                 <table class="table table-hover text-center mt-3"
                                     style="border-collapse: separate; border-spacing: 0;">
                                     <thead>
                                         <tr>
                                             <th style="white-space: nowrap;">Nomor</th>
                                             <th style="white-space: nowrap;">Nama Rayon</th>
                                             <th style="white-space: nowrap;">Nama Kepala keluarga</th>
                                             <th style="white-space: nowrap;">Nama Jemaat</th>
                                             <th style="white-space: nowrap;">Jenis Kelamin</th>
                                             <th style="white-space: nowrap;">Alamat</th>
                                             <th style="white-space: nowrap;">No. HP</th>
                                             <th style="white-space: nowrap;">Status Babtis</th>
                                             <th style="white-space: nowrap;">Status Sidi</th>
                                             <th style="white-space: nowrap;">Status Nikah</th>
                                             <th style="white-space: nowrap;">Aksi</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php
                                            $nomor = $offset + 1;
                                            while ($row = $result->fetch_assoc()):
                                            ?>
                                             <tr>
                                                 <td><?php echo $nomor++; ?></td>
                                                 <td>Rayon: <?php echo htmlspecialchars($row['nama_rayon']); ?></td>
                                                 <td><?php echo htmlspecialchars($row['nama_kepala_keluarga']); ?>
                                                 </td>
                                                 <td><?php echo htmlspecialchars($row['nama_jemaat']); ?>
                                                 </td>
                                                 <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?>
                                                 </td>
                                                 <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                                 <td><?php echo htmlspecialchars($row['no_hp']); ?></td>
                                                 <td><?php echo htmlspecialchars($row['status_babtis']); ?>
                                                 </td>
                                                 <td><?php echo htmlspecialchars($row['status_sidi']); ?>
                                                 </td>
                                                 <td><?php echo htmlspecialchars($row['status_nikah']); ?>
                                                 </td>
                                                 <td style="display: flex; justify-content: center; gap: 10px;">
                                                     <button class="btn btn-primary btn-sm" onclick="openEditModal(
                                                    '<?php echo $row['id_jemaat']; ?>',
                                                    '<?php echo $row['id_rayon']; ?>',
                                                    '<?php echo $row['id_kepala_keluarga']; ?>',
                                                    '<?php echo $row['nama_jemaat']; ?>',
                                                    '<?php echo $row['jenis_kelamin']; ?>',
                                                    '<?php echo $row['alamat']; ?>',
                                                    '<?php echo $row['no_hp']; ?>',
                                                    '<?php echo $row['status_babtis']; ?>',
                                                    '<?php echo $row['status_sidi']; ?>',
                                                    '<?php echo $row['status_nikah']; ?>')">Edit</button>
                                                     <button class="btn btn-danger btn-sm"
                                                         onclick="hapus('<?php echo $row['id_jemaat']; ?>')">Hapus</button>
                                                 </td>
                                             </tr>
                                         <?php endwhile; ?>
                                     </tbody>
                                 </table>
                             <?php else: ?>
                                 <p class="text-center mt-4">Data tidak ditemukan.</p>
                             <?php endif; ?>

                             <!-- Pagination -->
                             <nav>
                                 <ul class="pagination justify-content-center">
                                     <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                         <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                             <a class="page-link"
                                                 href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                                         </li>
                                     <?php endfor; ?>
                                 </ul>
                             </nav>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>


 </div>