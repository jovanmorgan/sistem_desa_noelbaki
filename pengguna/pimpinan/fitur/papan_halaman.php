<?php include 'nama_halaman.php'; ?>



<?php if ($page_title !== "Profile Saya" && $page_title !== "Dashboard"): ?>
    <nav a-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Master</a>
            </li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?= htmlspecialchars($page_title) ?>
            </li>
        </ol>
        <h6 class="font-weight-bolder text-white mb-0"><?= htmlspecialchars($page_title) ?></h6>
    </nav>
<?php endif; ?>

<?php if ($page_title === "Profile Saya" || $page_title === "Dashboard"): ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Admin</a>
            </li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?= htmlspecialchars($page_title) ?>
            </li>
        </ol>
        <h6 class="font-weight-bolder text-white mb-0"><?= htmlspecialchars($page_title) ?></h6>
    </nav>
<?php endif; ?>