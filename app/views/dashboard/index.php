<div class="card">
    <div class="card-header">
        <h1 class="card-title">Ringkasan Sistem Presensi</h1>
    </div>
    
    <div class="dashboard-grid">
        <div class="summary-card">
            <div class="summary-title">Total Kelas</div>
            <div class="summary-value"><?= (int)$total_kelas ?></div>
        </div>

        <div class="summary-card">
            <div class="summary-title">Total Guru</div>
            <div class="summary-value"><?= (int)$total_guru ?></div>
        </div>

        <div class="summary-card">
            <div class="summary-title">Total Mata Pelajaran</div>
            <div class="summary-value"><?= (int)$total_mapel ?></div>
        </div>

        <div class="summary-card">
            <div class="summary-title">Total Murid</div>
            <div class="summary-value"><?= (int)$total_murid ?></div>
        </div>
    </div>

    <div class="alert alert-info">
        <strong>Selamat Datang!</strong> Gunakan menu di bagian kiri untuk mengelola data master (Kelas, Guru, Mapel, Murid) atau langsung lakukan pengisian kehadiran pada menu <strong>Presensi</strong>.
    </div>

    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="<?= BASEURL ?>/presensi" class="btn btn-primary">Buka Halaman Presensi &rarr;</a>
        <a href="<?= BASEURL ?>/murid" class="btn btn-secondary">Kelola Data Murid</a>
        <a href="<?= BASEURL ?>/kelas" class="btn btn-secondary">Kelola Data Kelas</a>
    </div>
</div>
