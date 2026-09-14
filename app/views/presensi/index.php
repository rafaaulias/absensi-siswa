<div class="card">
    <div class="card-header">
        <h1 class="card-title">Pengisian Presensi Murid Bulanan (SMK)</h1>
    </div>

    <!-- Form Filter Presensi -->
    <form action="<?= BASEURL ?>/presensi" method="GET" style="margin-bottom: 24px;">
        <div class="form-row">
            <div class="form-group">
                <label for="id_kelas">Kelas <span style="color: red;">*</span></label>
                <select name="id_kelas" id="id_kelas" class="form-control" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php foreach ($kelas_list as $k): ?>
                        <option value="<?= $k['id_kelas'] ?>" <?= $selected_kelas == $k['id_kelas'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($k['nama_kelas']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_guru">Guru Pengajar <span style="color: red;">*</span></label>
                <select name="id_guru" id="id_guru" class="form-control" onchange="syncMapel(this)" required>
                    <option value="">-- Pilih Guru --</option>
                    <?php foreach ($guru_list as $g): ?>
                        <?php 
                        $mapelNames = !empty($g['mapels']) ? implode(', ', array_column($g['mapels'], 'nama_mapel')) : 'Belum ada mapel';
                        ?>
                        <option value="<?= $g['id_guru'] ?>" <?= $selected_guru == $g['id_guru'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($g['nama_guru']) ?> (<?= htmlspecialchars($mapelNames) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_mapel">Mata Pelajaran <span style="color: red;">*</span></label>
                <select name="id_mapel" id="id_mapel" class="form-control" required>
                    <?php if ($selected_guru > 0 && !empty($mapel_list)): ?>
                        <option value="">-- Pilih Mapel --</option>
                        <?php foreach ($mapel_list as $m): ?>
                            <option value="<?= $m['id_mapel'] ?>" <?= $selected_mapel == $m['id_mapel'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m['nama_mapel']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">-- Mata Pelajaran --</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group" style="max-width: 140px;">
                <label for="bulan">Bulan <span style="color: red;">*</span></label>
                <select name="bulan" id="bulan" class="form-control" onchange="limitBulanTahun()" required>
                    <?php 
                    $namaBulan = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                    foreach ($namaBulan as $num => $nama): 
                    ?>
                        <option value="<?= $num ?>" <?= $selected_bulan == $num ? 'selected' : '' ?>>
                            <?= $nama ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group" style="max-width: 130px;">
                <label for="tahun">Tahun <span style="color: red;">*</span></label>
                <select name="tahun" id="tahun" class="form-control" onchange="limitBulanTahun()" required>
                    <?php for ($y = 2020; $y <= $current_year; $y++): ?>
                        <option value="<?= $y ?>" <?= $selected_tahun == $y ? 'selected' : '' ?>>
                            <?= $y ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="form-group" style="display: flex; align-items: flex-end; max-width: 140px;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Tampilkan</button>
            </div>
        </div>
    </form>

    <?php if ($selected_kelas > 0 && $selected_guru > 0 && $selected_mapel > 0): ?>
        <?php if (!empty($murid_list)): ?>
            <!-- Legend Keterangan Status -->
            <div class="legend-box" style="margin-bottom: 16px;">
                <strong>Keterangan Status:</strong>
                <div class="legend-item"><span class="badge badge-H">H</span> Hadir</div>
                <div class="legend-item"><span class="badge badge-I">I</span> Izin</div>
                <div class="legend-item"><span class="badge badge-S">S</span> Sakit</div>
                <div class="legend-item"><span class="badge badge-A">A</span> Alpa</div>
                <div class="legend-item" style="color: var(--text-muted);">(kosong) Belum diisi</div>
            </div>

            <!-- Form Utama Batch Presensi -->
            <form action="<?= BASEURL ?>/presensi/store" method="POST">
                <input type="hidden" name="id_kelas" value="<?= $selected_kelas ?>">
                <input type="hidden" name="id_guru" value="<?= $selected_guru ?>">
                <input type="hidden" name="id_mapel" value="<?= $selected_mapel ?>">
                <input type="hidden" name="bulan" value="<?= $selected_bulan ?>">
                <input type="hidden" name="tahun" value="<?= $selected_tahun ?>">

                <div class="matrix-container">
                    <table class="matrix-table">
                        <thead>
                            <tr>
                                <th class="col-no sticky-col" style="left: 0;">No</th>
                                <th class="sticky-col" style="left: 40px; width: 50px; text-align: center;">Absen</th>
                                <th class="col-nama sticky-col" style="left: 90px;">Nama Murid</th>
                                <?php for ($tgl = 1; $tgl <= $jumlah_hari; $tgl++): ?>
                                    <th style="width: 42px;"><?= $tgl ?></th>
                                <?php endfor; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($murid_list as $m): ?>
                                <tr>
                                    <td class="col-no sticky-col" style="left: 0;"><?= $no++ ?></td>
                                    <td class="sticky-col" style="left: 40px; width: 50px; text-align: center; font-weight: 700;">
                                        <?= (int)$m['no_absen'] ?>
                                    </td>
                                    <td class="col-nama sticky-col" style="left: 90px;">
                                        <?= htmlspecialchars($m['nama_murid']) ?>
                                    </td>
                                    <?php for ($tgl = 1; $tgl <= $jumlah_hari; $tgl++): 
                                        $currentStatus = isset($matrix[$m['id_murid']][$tgl]) ? $matrix[$m['id_murid']][$tgl] : '';
                                    ?>
                                        <td>
                                            <select name="status[<?= $m['id_murid'] ?>][<?= $tgl ?>]" 
                                                    class="status-select status-<?= $currentStatus ?>"
                                                    onchange="this.className = 'status-select status-' + this.value">
                                                <option value="" <?= $currentStatus === '' ? 'selected' : '' ?>></option>
                                                <option value="H" <?= $currentStatus === 'H' ? 'selected' : '' ?>>H</option>
                                                <option value="I" <?= $currentStatus === 'I' ? 'selected' : '' ?>>I</option>
                                                <option value="S" <?= $currentStatus === 'S' ? 'selected' : '' ?>>S</option>
                                                <option value="A" <?= $currentStatus === 'A' ? 'selected' : '' ?>>A</option>
                                            </select>
                                        </td>
                                    <?php endfor; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary" style="font-size: 15px; padding: 10px 24px;">
                        Simpan Presensi
                    </button>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-danger">
                Tidak ada murid yang terdaftar dalam kelas ini. Silakan tambahkan murid di menu <strong>Murid</strong> terlebih dahulu.
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info" style="text-align: center; padding: 30px;">
            Silakan pilih <strong>Kelas, Guru, Mata Pelajaran, Bulan, dan Tahun</strong> di atas, lalu klik <strong>Tampilkan</strong> untuk mengisi presensi.
        </div>
    <?php endif; ?>
</div>

<script>
const GURU_MAPEL_MAP = <?= json_encode($guru_mapel_map) ?>;
const MAPEL_NAMES = <?= json_encode($mapel_names, JSON_UNESCAPED_UNICODE) ?>;
const CURRENT_MONTH = <?= (int)$current_month ?>;
const CURRENT_YEAR = <?= (int)$current_year ?>;

function syncMapel(guruSelect) {
    const guruId = guruSelect.value;
    const mapelSelect = document.getElementById('id_mapel');
    if (!guruId) {
        mapelSelect.innerHTML = '<option value="">-- Mata Pelajaran --</option>';
        return;
    }
    const ids = GURU_MAPEL_MAP[guruId] || [];
    if (ids.length === 0) {
        mapelSelect.innerHTML = '<option value="">(Guru belum memiliki mapel)</option>';
        return;
    }
    mapelSelect.innerHTML = '<option value="">-- Pilih Mapel --</option>';
    ids.forEach(function(id) {
        const opt = document.createElement('option');
        opt.value = id;
        opt.textContent = MAPEL_NAMES[id] || '';
        mapelSelect.appendChild(opt);
    });
    if (ids.length > 0) {
        mapelSelect.value = ids[0];
    }
}

function limitBulanTahun() {
    const tahun = parseInt(document.getElementById('tahun').value, 10);
    const bulan = document.getElementById('bulan');
    if (tahun === CURRENT_YEAR) {
        Array.from(bulan.options).forEach(function(opt, idx) {
            if (idx > 0) opt.disabled = (idx > CURRENT_MONTH);
        });
        if (parseInt(bulan.value, 10) > CURRENT_MONTH) {
            bulan.value = CURRENT_MONTH;
        }
    } else {
        Array.from(bulan.options).forEach(function(opt) {
            opt.disabled = false;
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    limitBulanTahun();
});
</script>
