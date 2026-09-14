<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) . ' - ' : '' ?>Dashboard Presensi Sekolah</title>
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/style.css">
</head>
<body>

    <!-- ============================================================ -->
    <!-- NAVBAR LAMA (DISIMPAN AGAR TIDAK DIHAPUS BILA DIBUTUHKAN NANTI) -->
    <!-- ============================================================ -->
    <!-- 
    <header class="old-navbar">
        <div class="navbar">
            <a href="<?= BASEURL ?>" class="navbar-brand">Daftar Hadir Murid</a>
            <ul class="navbar-nav">
                <li><a href="<?= BASEURL ?>" class="nav-link <?= (isset($title) && strpos($title, 'Dashboard') !== false) ? 'active' : '' ?>">Beranda</a></li>
                <li><a href="<?= BASEURL ?>/kelas" class="nav-link <?= (isset($title) && strpos($title, 'Kelas') !== false) ? 'active' : '' ?>">Kelas</a></li>
                <li><a href="<?= BASEURL ?>/guru" class="nav-link <?= (isset($title) && strpos($title, 'Guru') !== false) ? 'active' : '' ?>">Guru</a></li>
                <li><a href="<?= BASEURL ?>/mapel" class="nav-link <?= (isset($title) && strpos($title, 'Mata Pelajaran') !== false) ? 'active' : '' ?>">Mapel</a></li>
                <li><a href="<?= BASEURL ?>/murid" class="nav-link <?= (isset($title) && strpos($title, 'Murid') !== false) ? 'active' : '' ?>">Murid</a></li>
                <li><a href="<?= BASEURL ?>/presensi" class="nav-link <?= (isset($title) && strpos($title, 'Presensi') !== false) ? 'active' : '' ?>">Presensi</a></li>
            </ul>
        </div>
    </header>
    -->

    <!-- LAYOUT DENGAN SIDEBAR NAVIGASI UTAMA -->
    <div class="app-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="<?= BASEURL ?>" class="sidebar-brand">Daftar Hadir Murid</a>
            </div>
            <ul class="sidebar-nav">
                <li>
                    <a href="<?= BASEURL ?>" class="sidebar-link <?= (isset($title) && strpos($title, 'Dashboard') !== false) ? 'active' : '' ?>">
                        <span>Beranda</span>
                    </a>
                </li>
                <li>
                    <a href="<?= BASEURL ?>/kelas" class="sidebar-link <?= (isset($title) && strpos($title, 'Kelas') !== false) ? 'active' : '' ?>">
                        <span>Data Kelas</span>
                    </a>
                </li>
                <li>
                    <a href="<?= BASEURL ?>/guru" class="sidebar-link <?= (isset($title) && strpos($title, 'Guru') !== false) ? 'active' : '' ?>">
                        <span>Data Guru</span>
                    </a>
                </li>
                <li>
                    <a href="<?= BASEURL ?>/mapel" class="sidebar-link <?= (isset($title) && strpos($title, 'Mata Pelajaran') !== false) ? 'active' : '' ?>">
                        <span>Data Mapel</span>
                    </a>
                </li>
                <li>
                    <a href="<?= BASEURL ?>/murid" class="sidebar-link <?= (isset($title) && strpos($title, 'Murid') !== false) ? 'active' : '' ?>">
                        <span>Data Murid</span>
                    </a>
                </li>
                <li>
                    <a href="<?= BASEURL ?>/presensi" class="sidebar-link <?= (isset($title) && strpos($title, 'Presensi') !== false) ? 'active' : '' ?>">
                        <span>Presensi</span>
                    </a>
                </li>
            </ul>
        </aside>

        <div class="main-wrapper">
            <main class="container">
                <?php 
                // Render Alert / Notifikasi Flasher jika ada pesan session
                if (class_exists('Flasher')) {
                    Flasher::flash();
                }
                ?>
