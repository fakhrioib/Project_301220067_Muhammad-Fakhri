<?php
$active = function ($route) {
    $uri = $_SERVER['REQUEST_URI'];
    return strpos($uri, $route) !== false ? 'active' : '';
};
?>
<div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white" style="width: 250px; min-height: 100vh;">
    <a href="<?= base_url('dashboard') ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4"><i class="fas fa-qrcode me-2"></i>Operator</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= base_url('dashboard') ?>" class="nav-link text-white <?= $active('dashboard') ?>">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?= base_url('absensi_siswa') ?>" class="nav-link text-white <?= $active('absensi_siswa') ?>">
                <i class="fas fa-users me-2"></i> Absensi Siswa
            </a>
        </li>
        <li>
            <a href="<?= base_url('absensi_guru') ?>" class="nav-link text-white <?= $active('absensi_guru') ?>">
                <i class="fas fa-user-tie me-2"></i> Absensi Guru
            </a>
        </li>
        <li>
            <a href="<?= base_url('data_siswa') ?>" class="nav-link text-white <?= $active('data_siswa') ?>">
                <i class="fas fa-database me-2"></i> Data Siswa
            </a>
        </li>
        <li>
            <a href="<?= base_url('data_guru') ?>" class="nav-link text-white <?= $active('data_guru') ?>">
                <i class="fas fa-chalkboard-teacher me-2"></i> Data Guru
            </a>
        </li>
        <li>
            <a href="<?= base_url('generate_qr') ?>" class="nav-link text-white <?= $active('generate_qr') ?>">
                <i class="fas fa-qrcode me-2"></i> Generate QR Code
            </a>
        </li>
        <li>
            <a href="<?= base_url('generate_laporan') ?>" class="nav-link text-white <?= $active('generate_laporan') ?>">
                <i class="fas fa-file-alt me-2"></i> Generate Laporan
            </a>
        </li>
        <li>
            <a href="<?= base_url('data_petugas') ?>" class="nav-link text-white <?= $active('data_petugas') ?>">
                <i class="fas fa-user-cog me-2"></i> Data Petugas
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name']) ?>&background=6c757d&color=fff" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong><?= $user['name'] ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">Logout</a></li>
        </ul>
    </div>
</div>