<div class="card" style="max-width: 500px; margin: 0 auto;">
    <div class="card-header">
        <h1 class="card-title">Tambah Mata Pelajaran Baru</h1>
    </div>

    <form action="<?= BASEURL ?>/mapel/store" method="POST">
        <div class="form-group">
            <label for="nama_mapel">Nama Mata Pelajaran <span style="color: red;">*</span></label>
            <input type="text" id="nama_mapel" name="nama_mapel" class="form-control" placeholder="Contoh: Matematika" required autofocus>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= BASEURL ?>/mapel" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
