<div class="card">
    <div class="card-header">
        <h1 class="card-title">Data Kelas</h1>
        <a href="<?= BASEURL ?>/kelas/create" class="btn btn-primary">+ Tambah Kelas</a>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Kelas</th>
                    <th style="width: 160px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($kelas)): ?>
                    <?php $no = 1; foreach ($kelas as $k): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong><?= htmlspecialchars($k['nama_kelas']) ?></strong></td>
                            <td style="text-align: center;">
                                <a href="<?= BASEURL ?>/kelas/edit/<?= $k['id_kelas'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                                <a href="<?= BASEURL ?>/kelas/delete/<?= $k['id_kelas'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kelas ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--text-muted);">Belum ada data kelas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
