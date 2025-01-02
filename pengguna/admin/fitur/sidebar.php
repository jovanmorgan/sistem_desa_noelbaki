<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Fungsi untuk mendapatkan ikon yang sesuai dengan halaman
function getIconForPage($page)
{
    switch ($page) {
        case 'dashboard':
            return 'fas fa-chart-line'; // Ikon statistik untuk dashboard
        case 'kontak':
            return 'fas fa-phone'; // Ikon untuk Kontak
        case 'profile':
            return 'fas fa-user-circle'; // Ikon profil pengguna
        case 'log_out':
            return 'fas fa-sign-out-alt'; // Ikon keluar
        default:
            return 'fas fa-folder'; // Ikon default jika halaman tidak dikenal
    }
}

// Daftar halaman dalam menu "Master"
$master_pages = [
    'pimpinan',
    'rt',
    'kepala_keluarga',
    'anggota_keluarga',
    'kkm',
    // 'validasi_kkm',
    'permohonan_bantuan'
];
$is_master_active = in_array($current_page, $master_pages);
?>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main" data-color="warning" style="z-index: 99;">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="dashboard">
            <img src="../../assets/img-umum/umum/logo.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1"
                style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; font-size: 20px; position: relative; bottom: -4px;">
                Desa Noelbaki
            </span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: auto;">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>" href="dashboard">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="<?php echo getIconForPage('dashboard'); ?> text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($is_master_active) ? 'collapsed' : ''; ?>" data-bs-toggle="collapse"
                    href="#masterDropdown" role="button"
                    aria-expanded="<?php echo $is_master_active ? 'true' : 'false'; ?>" aria-controls="masterDropdown">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-folder-17 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">MASTER</span>
                </a>
                <div class="collapse <?php echo $is_master_active ? 'show' : ''; ?>" id="masterDropdown">
                    <ul class="navbar-nav ps-4">
                        <?php
                        foreach ($master_pages as $page) {
                            $icon = ($current_page == $page) ? 'text-white' : 'text-sm opacity-10';
                            $active_class = ($current_page == $page) ? 'active' : '';
                            $icon_class = ($page == 'pimpinan') ? 'fas fa-user-tie' : ($page == 'rt' ? 'fas fa-users' : ($page == 'kepala_keluarga' ? 'fas fa-home' : ($page == 'anggota_keluarga' ? 'fas fa-user' : ($page == 'kkm' ? 'fas fa-hand-holding-heart' : 'fas fa-envelope-open-text'))));
                        ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo $active_class; ?>" href="<?php echo $page; ?>">
                                    <i class="<?php echo $icon_class; ?> <?php echo $icon; ?> me-2"></i>
                                    <span class="nav-link-text"><?php echo ucwords(str_replace('_', ' ', $page)); ?></span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'kontak') ? 'active' : ''; ?>" href="kontak">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="<?php echo getIconForPage('kontak'); ?> text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kontak</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'profile') ? 'active' : ''; ?>" href="profile">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'log_out') ? 'active' : ''; ?>" href="log_out">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="<?php echo getIconForPage('log_out'); ?> text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Log Out</span>
                </a>
            </li>
        </ul>
    </div>
</aside>