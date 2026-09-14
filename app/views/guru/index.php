<div class="card">
    <div class="card-header">
        <h1 class="card-title">Data Guru Pengajar</h1>
        <a href="<?= BASEURL ?>/guru/create" class="btn btn-primary">+ Tambah Guru</a>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Guru</th>
                    <th>Mata Pelajaran Diampu</th>
                    <th style="width: 160px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($guru)): ?>
                    <?php $no = 1; foreach ($guru as $g): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong><?= htmlspecialchars($g['nama_guru']) ?></strong></td>
                            <td>
                                <?php if (!empty($g['mapels'])): ?>
                                    <?php foreach ($g['mapels'] as $m): ?>
                                        <span class="badge" style="background: #f4f4f5; color: #18181b; border: 1px solid #d4d4d8; font-size: 12px; padding: 4px 8px; margin: 2px 0; display: inline-block;"><?= htmlspecialchars($m['nama_mapel']) ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span style="color: var(--text-muted); font-style: italic;">Belum diatur</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?= BASEURL ?>/guru/edit/<?= $g['id_guru'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                                <a href="<?= BASEURL ?>/guru/delete/<?= $g['id_guru'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus guru ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted);">Belum ada data guru.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
