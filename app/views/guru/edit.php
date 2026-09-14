<div class="card" style="max-width: 650px; margin: 0 auto;">
    <div class="card-header">
        <h1 class="card-title">Edit Data Guru</h1>
    </div>

    <form action="<?= BASEURL ?>/guru/update/<?= $guru['id_guru'] ?>" method="POST">
        <div class="form-group">
            <label for="nama_guru">Nama Lengkap Guru <span style="color: red;">*</span></label>
            <input type="text" id="nama_guru" name="nama_guru" class="form-control" value="<?= htmlspecialchars($guru['nama_guru']) ?>" required autofocus>
        </div>

        <div class="form-group">
            <label>Mata Pelajaran Yang Diampu <span id="mapel-counter" class="selected-count-badge">0 dipilih</span></label>
            <div class="mapel-selector-container">
                <div class="mapel-toolbar">
                    <div class="mapel-search-wrapper">
                        <!-- <span class="mapel-search-icon"></span> -->
                        <input type="text" id="search-mapel" class="mapel-search-input" placeholder="Cari mata pelajaran..." onkeyup="filterMapel()">
                    </div>
                    <div class="mapel-actions">
                        <button type="button" class="btn btn-secondary btn-xs" onclick="selectAllMapel(true)">Pilih Semua</button>
                        <button type="button" class="btn btn-secondary btn-xs" onclick="selectAllMapel(false)">Hapus Semua</button>
                    </div>
                </div>

                <div class="mapel-grid" id="mapel-grid">
                    <?php 
                    $selectedMapels = $guru['mapel_ids'] ?? [];
                    if (!empty($mapel)): 
                    ?>
                        <?php foreach ($mapel as $m): 
                            $isSelected = in_array($m['id_mapel'], $selectedMapels);
                        ?>
                            <label class="mapel-checkbox-card <?= $isSelected ? 'selected' : '' ?>" id="card-mapel-<?= $m['id_mapel'] ?>">
                                <input type="checkbox" name="id_mapel[]" value="<?= $m['id_mapel'] ?>" <?= $isSelected ? 'checked' : '' ?> onchange="updateCardState(this)">
                                <span class="mapel-card-title"><?= htmlspecialchars($m['nama_mapel']) ?></span>
                            </label>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="mapel-empty-notice">Belum ada mata pelajaran. Silakan tambahkan di menu Data Mapel.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Update Data Guru</button>
            <a href="<?= BASEURL ?>/guru" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
function updateCardState(checkbox) {
    const card = checkbox.closest('.mapel-checkbox-card');
    if (checkbox.checked) {
        card.classList.add('selected');
    } else {
        card.classList.remove('selected');
    }
    updateSelectedCount();
}

function updateSelectedCount() {
    const count = document.querySelectorAll('input[name="id_mapel[]"]:checked').length;
    const badge = document.getElementById('mapel-counter');
    if (badge) {
        badge.textContent = count + ' dipilih';
    }
}

function selectAllMapel(select) {
    const visibleCards = document.querySelectorAll('.mapel-checkbox-card:not([style*="display: none"])');
    visibleCards.forEach(card => {
        const checkbox = card.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.checked = select;
            updateCardState(checkbox);
        }
    });
}

function filterMapel() {
    const query = document.getElementById('search-mapel').value.toLowerCase();
    const cards = document.querySelectorAll('.mapel-checkbox-card');
    cards.forEach(card => {
        const title = card.querySelector('.mapel-card-title').textContent.toLowerCase();
        if (title.includes(query)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    updateSelectedCount();
});
</script>

