 <div id="load_data">
     <section class="section">
         <div class="row">
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-body text-center">
                         <!-- Search Form -->
                         <form method="GET" action="">
                             <div class="input-group mt-3">
                                 <input type="text" class="form-control" placeholder="Cari pengumuman..." name="search"
                                     value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                 <button class="btn btn-outline-secondary" type="submit">Cari</button>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </section>

     <section class="section">
         <div class="row align-items-start">
             <?php
                include '../../../../keamanan/koneksi.php';

                $limit = 6;
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

                $total_result = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pengumuman WHERE judul LIKE '%$search%' OR isi_pengumuman LIKE '%$search%' OR jenis_pengumuman LIKE '%$search%' OR waktu LIKE '%$search%' OR foto LIKE '%$search%'");
                $total_row = mysqli_fetch_assoc($total_result);
                $total_items = $total_row['total'];
                $total_pages = ceil($total_items / $limit);

                $result = mysqli_query($koneksi, "SELECT * FROM pengumuman WHERE judul LIKE '%$search%' OR isi_pengumuman LIKE '%$search%' OR jenis_pengumuman LIKE '%$search%' OR waktu LIKE '%$search%' OR foto LIKE '%$search%' LIMIT $limit OFFSET $offset");

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id_pengumuman = $row['id_pengumuman'];
                        $judul = $row['judul'];
                        $isi_pengumuman = $row['isi_pengumuman'];
                        $jenis_pengumuman = $row['jenis_pengumuman'];
                        $waktu = $row['waktu'];
                        $foto = $row['foto'];
                ?>

                     <div class="col-lg-4 mb-4">
                         <div class="card h-100 shadow-lg"
                             style="border-radius: 15px; transition: transform 0.3s, box-shadow 0.3s; background: white;">
                             <div class="card-body text-center">
                                 <h5 class="card-title"
                                     style="font-family: 'Poppins', sans-serif; font-weight: bold; color: #007bff;">
                                     <?php echo $judul; ?> </h5>
                                 <div class="carousel slide" data-bs-ride="carousel">
                                     <div class="carousel-inner">
                                         <div class="carousel-item active">
                                             <img src="../../assets/img/pengumuman/<?php echo $foto; ?>"
                                                 class="d-block w-100 rounded" alt="<?php echo $judul; ?>"
                                                 style="border-radius: 10px;" />
                                         </div>
                                     </div>
                                 </div>
                                 <p class="mt-3 text-muted small">Diposting pada: <?php echo $waktu; ?></p>
                                 <hr>
                                 <p><strong>Jenis:</strong> <?php echo $jenis_pengumuman; ?></p>
                                 <p>"<?php echo $isi_pengumuman; ?>"</p>
                                 <div class="d-flex justify-content-between mt-3">
                                     <button onclick="hapus('<?php echo $id_pengumuman; ?>');"
                                         class="btn btn-danger btn-sm shadow">Hapus</button>
                                     <button
                                         onclick="openEditModal('<?php echo $id_pengumuman; ?>', '<?php echo addslashes($judul); ?>', '<?php echo $isi_pengumuman; ?>', '<?php echo addslashes($jenis_pengumuman); ?>', '<?php echo addslashes($waktu); ?>', '<?php echo addslashes($foto); ?>');"
                                         class="btn btn-primary btn-sm shadow">Edit</button>
                                 </div>
                             </div>
                         </div>
                     </div>
             <?php
                    }
                } else {
                    echo "<div class='col-12'><p class='text-center text-muted'>Tidak ada data pengumuman 😖.</p></div>";
                }
                ?>
         </div>
     </section>

     <section class="section">
         <div class="row">
             <div class="col-lg-12">
                 <div class="card shadow-lg border-0">
                     <div class="card-body text-center">
                         <nav aria-label="Page navigation example">
                             <ul class="pagination justify-content-center">
                                 <li class="page-item <?php if ($page <= 1) {
                                                            echo 'disabled';
                                                        } ?>">
                                     <a class="page-link" href="<?php if ($page > 1) {
                                                                    echo "?page=" . ($page - 1) . "&search=" . $search;
                                                                } ?>" aria-label="Previous"
                                         style="border-radius: 50px;">
                                         <span aria-hidden="true">&laquo;</span>
                                     </a>
                                 </li>
                                 <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                     <li class="page-item <?php if ($i == $page) {
                                                                echo 'active';
                                                            } ?>">
                                         <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"
                                             style="border-radius: 50px;"> <?php echo $i; ?> </a>
                                     </li>
                                 <?php } ?>
                                 <li class="page-item <?php if ($page >= $total_pages) {
                                                            echo 'disabled';
                                                        } ?>">
                                     <a class="page-link" href="<?php if ($page < $total_pages) {
                                                                    echo "?page=" . ($page + 1) . "&search=" . $search;
                                                                } ?>" aria-label="Next" style="border-radius: 50px;">
                                         <span aria-hidden="true">&raquo;</span>
                                     </a>
                                 </li>
                             </ul>
                         </nav>
                     </div>
                 </div>
             </div>
         </div>
     </section>
 </div>