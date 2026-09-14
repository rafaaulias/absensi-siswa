<div class="card">
    <div class="card-header">
        <h1 class="card-title">Data Murid</h1>
        <a href="<?= BASEURL ?>/murid/create" class="btn btn-primary">+ Tambah Murid</a>
    </div>

    <form method="GET" action="<?= BASEURL ?>/murid" style="margin-bottom: 20px;">
        <div class="form-group" style="margin-bottom: 0; max-width: 300px;">
            <label for="kelas">Filter Kelas</label>
            <select id="kelas" name="kelas" class="form-control" onchange="this.form.submit()">
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>" <?= $k['id_kelas'] == $selectedKelas ? 'selected' : '' ?>>
                        <?= htmlspecialchars($k['nama_kelas']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 90px; text-align: center;">No. Absen</th>
                    <th>Nama Murid</th>
                    <th>Kelas</th>
                    <th style="width: 160px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($murid)): ?>
                    <?php $no = 1; foreach ($murid as $m): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="text-align: center; font-weight: 700; color: var(--primary);"><?= (int)$m['no_absen'] ?></td>
                            <td><strong><?= htmlspecialchars($m['nama_murid']) ?></strong></td>
                            <td><span class="badge" style="background: #f4f4f5; color: #18181b; border: 1px solid #d4d4d8; font-size: 12px; padding: 4px 8px;"><?= htmlspecialchars($m['nama_kelas'] ?? 'Tanpa Kelas') ?></span></td>
                            <td style="text-align: center;">
                                <a href="<?= BASEURL ?>/murid/edit/<?= $m['id_murid'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                                <a href="<?= BASEURL ?>/murid/delete/<?= $m['id_murid'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus murid ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted);">Belum ada data murid.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
