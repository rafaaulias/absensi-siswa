<div class="card" style="max-width: 500px; margin: 0 auto;">
    <div class="card-header">
        <h1 class="card-title">Edit Data Kelas</h1>
    </div>

    <form action="<?= BASEURL ?>/kelas/update/<?= $kelas['id_kelas'] ?>" method="POST">
        <div class="form-group">
            <label for="nama_kelas">Nama Kelas <span style="color: red;">*</span></label>
            <input type="text" id="nama_kelas" name="nama_kelas" class="form-control" value="<?= htmlspecialchars($kelas['nama_kelas']) ?>" required autofocus>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= BASEURL ?>/kelas" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
