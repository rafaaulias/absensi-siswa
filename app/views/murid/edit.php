<div class="card" style="max-width: 500px; margin: 0 auto;">
    <div class="card-header">
        <h1 class="card-title">Edit Data Murid</h1>
    </div>

    <form action="<?= BASEURL ?>/murid/update/<?= $murid['id_murid'] ?>" method="POST">
        <div class="form-group">
            <label for="no_absen">No. Absen <span style="color: red;">*</span></label>
            <input type="number" id="no_absen" name="no_absen" class="form-control" value="<?= (int)$murid['no_absen'] ?>" min="1" max="100" required autofocus>
        </div>

        <div class="form-group">
            <label for="nama_murid">Nama Murid <span style="color: red;">*</span></label>
            <input type="text" id="nama_murid" name="nama_murid" class="form-control" value="<?= htmlspecialchars($murid['nama_murid']) ?>" required>
        </div>

        <div class="form-group">
            <label for="id_kelas">Pilih Kelas <span style="color: red;">*</span></label>
            <select id="id_kelas" name="id_kelas" class="form-control" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>" <?= $k['id_kelas'] == $murid['id_kelas'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($k['nama_kelas']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= BASEURL ?>/murid" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
