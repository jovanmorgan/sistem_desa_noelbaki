 <div id="load_data">
     <!-- Contact Start -->
     <div class="container-xxl py-5">
         <div class="container">
             <div class="row g-4">

                 <?php
                    include '../../../../keamanan/koneksi.php';

                    // Ambil data kontak dengan id_kontak = 1
                    $id_kontak = 1;
                    $query = "SELECT * FROM kontak WHERE id_kontak = '$id_kontak'";
                    $result = mysqli_query($koneksi, $query);

                    // Jika data ditemukan, simpan nilai ke dalam variabel
                    if ($row = mysqli_fetch_assoc($result)) {
                        $alamat = $row['alamat'];
                        $nomor_telpon = $row['nomor_telpon'];
                        $email = $row['email'];
                    } else {
                        // Default nilai jika data tidak ditemukan
                        $alamat = "Alamat belum tersedia";
                        $nomor_telpon = "Nomor belum tersedia";
                        $email = "Email belum tersedia";
                    }

                    // Tutup koneksi
                    mysqli_close($koneksi);
                    ?>

                 <!-- Address Section -->
                 <div class="col-lg-4 col-md-6">
                     <div class="h-100 bg-light rounded shadow-sm d-flex align-items-center p-4">
                         <div class="icon-box bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                             style="width: 60px; height: 60px;">
                             <i class="fa fa-map-marker-alt text-primary fs-4"></i>
                         </div>
                         <div class="ms-3">
                             <p class="text-muted mb-1">Alamat Gereja</p>
                             <h5 class="fw-bold mb-0"><?= htmlspecialchars($alamat); ?></h5>
                         </div>
                     </div>
                 </div>

                 <!-- Phone Section -->
                 <div class="col-lg-4 col-md-6">
                     <div class="h-100 bg-light rounded shadow-sm d-flex align-items-center p-4">
                         <div class="icon-box bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                             style="width: 60px; height: 60px;">
                             <i class="fa fa-phone text-primary fs-4"></i>
                         </div>
                         <div class="ms-3">
                             <p class="text-muted mb-1">Hubungi Kami</p>
                             <h5 class="fw-bold mb-0"><?= htmlspecialchars($nomor_telpon); ?></h5>
                         </div>
                     </div>
                 </div>

                 <!-- Email Section -->
                 <div class="col-lg-4 col-md-6">
                     <div class="h-100 bg-light rounded shadow-sm d-flex align-items-center p-4">
                         <div class="icon-box bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                             style="width: 60px; height: 60px;">
                             <i class="fa fa-envelope-open text-primary fs-4"></i>
                         </div>
                         <div class="ms-3">
                             <p class="text-muted mb-1">Email Kami</p>
                             <h5 class="fw-bold mb-0"><?= htmlspecialchars($email); ?></h5>
                         </div>
                     </div>
                 </div>

                 <!-- Map Section -->
                 <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                     <div class="h-100" style="min-height: 400px;">
                         <iframe class="rounded shadow-sm w-100 h-100"
                             src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.340154350573!2d123.5474795!3d-10.1909198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c569b8d1affb65f%3A0x8b7f84488a50c23b!2sMarlinselan!5e0!3m2!1sen!2sid!4v1702828290123!5m2!1sen!2sid"
                             frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- Contact End -->
 </div>