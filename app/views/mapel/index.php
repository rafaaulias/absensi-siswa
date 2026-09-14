<div class="card">
    <div class="card-header">
        <h1 class="card-title">Data Mata Pelajaran</h1>
        <a href="<?= BASEURL ?>/mapel/create" class="btn btn-primary">+ Tambah Mapel</a>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Mata Pelajaran</th>
                    <th style="width: 160px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($mapel)): ?>
                    <?php $no = 1; foreach ($mapel as $m): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong><?= htmlspecialchars($m['nama_mapel']) ?></strong></td>
                            <td style="text-align: center;">
                                <a href="<?= BASEURL ?>/mapel/edit/<?= $m['id_mapel'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                                <a href="<?= BASEURL ?>/mapel/delete/<?= $m['id_mapel'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus mata pelajaran ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--text-muted);">Belum ada data mata pelajaran.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
