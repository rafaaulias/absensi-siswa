<div class="card" style="max-width: 500px; margin: 0 auto;">
    <div class="card-header">
        <h1 class="card-title">Tambah Murid Baru</h1>
    </div>

    <form action="<?= BASEURL ?>/murid/store" method="POST">
        <div class="form-group">
            <label for="no_absen">No. Absen <span style="color: red;">*</span></label>
            <input type="number" id="no_absen" name="no_absen" class="form-control" placeholder="Contoh: 18" min="1" max="100" value="1" required autofocus>
        </div>

        <div class="form-group">
            <label for="nama_murid">Nama Murid <span style="color: red;">*</span></label>
            <input type="text" id="nama_murid" name="nama_murid" class="form-control" placeholder="Contoh: Made Agus Astika Putra" required>
        </div>

        <div class="form-group">
            <label for="id_kelas">Pilih Kelas <span style="color: red;">*</span></label>
            <select id="id_kelas" name="id_kelas" class="form-control" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>"><?= htmlspecialchars($k['nama_kelas']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= BASEURL ?>/murid" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
