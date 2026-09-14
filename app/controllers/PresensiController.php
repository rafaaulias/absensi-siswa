<?php

class PresensiController extends Controller {
    private $presensiModel;
    private $kelasModel;
    private $guruModel;
    private $muridModel;

    public function __construct() {
        $this->presensiModel = new PresensiModel();
        $this->kelasModel = new KelasModel();
        $this->guruModel = new GuruModel();
        $this->muridModel = new MuridModel();
    }

    public function index() {
        $id_kelas = isset($_GET['id_kelas']) ? (int)$_GET['id_kelas'] : 0;
        $id_guru = isset($_GET['id_guru']) ? (int)$_GET['id_guru'] : 0;
        $id_mapel = isset($_GET['id_mapel']) ? (int)$_GET['id_mapel'] : 0;
        $bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : (int)date('n');
        $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : (int)date('Y');

        $currentYear = (int)date('Y');
        $currentMonth = (int)date('n');

        // Batasi bulan & tahun agar tidak melebihi tanggal sekarang
        if ($tahun > $currentYear) {
            $tahun = $currentYear;
        }
        if ($tahun == $currentYear && $bulan > $currentMonth) {
            $bulan = $currentMonth;
        }
        if ($tahun < 2020) {
            $tahun = 2020;
        }

        $kelas = $this->kelasModel->getAll();
        $guru = $this->guruModel->getAll();

        // Mapel hanya yang diampu oleh guru terpilih (fitur sinkron guru & mapel)
        $mapel = $id_guru > 0 ? $this->guruModel->getMapelByGuru($id_guru) : [];

        // Jika mapel terpilih tidak sinkron dengan guru, reset ke mapel pertama guru
        if ($id_guru > 0) {
            $validIds = array_column($mapel, 'id_mapel');
            if (!in_array($id_mapel, $validIds)) {
                $id_mapel = !empty($validIds) ? (int)$validIds[0] : 0;
            }
        } else {
            $id_mapel = 0;
        }

        // Peta guru_id => [id_mapel, ...] untuk JS filter dropdown
        $guruMapelMap = [];
        $allMapelNames = [];
        foreach ($guru as $g) {
            $guruMapelMap[$g['id_guru']] = array_map('intval', $g['mapel_ids']);
            foreach ($g['mapels'] as $m) {
                $allMapelNames[(int)$m['id_mapel']] = $m['nama_mapel'];
            }
        }

        $muridList = [];
        $matrix = [];
        $jumlahHari = 0;

        if ($id_kelas > 0 && $id_guru > 0 && $id_mapel > 0) {
            $muridList = $this->muridModel->getByKelas($id_kelas);
            $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
            $matrix = $this->presensiModel->getPresensiBulan($id_kelas, $id_guru, $id_mapel, $bulan, $tahun);
        }

        $data = [
            'title' => 'Pengisian Presensi Murid',
            'kelas_list' => $kelas,
            'guru_list' => $guru,
            'mapel_list' => $mapel,
            'guru_mapel_map' => $guruMapelMap,
            'mapel_names' => $allMapelNames,
            'selected_kelas' => $id_kelas,
            'selected_guru' => $id_guru,
            'selected_mapel' => $id_mapel,
            'selected_bulan' => $bulan,
            'selected_tahun' => $tahun,
            'current_month' => $currentMonth,
            'current_year' => $currentYear,
            'murid_list' => $muridList,
            'matrix' => $matrix,
            'jumlah_hari' => $jumlahHari
        ];

        $this->view('presensi/index', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_kelas = (int)($_POST['id_kelas'] ?? 0);
            $id_guru = (int)($_POST['id_guru'] ?? 0);
            $id_mapel = (int)($_POST['id_mapel'] ?? 0);
            $bulan = (int)($_POST['bulan'] ?? date('n'));
            $tahun = (int)($_POST['tahun'] ?? date('Y'));
            $statusData = $_POST['status'] ?? [];

            $currentYear = (int)date('Y');
            $currentMonth = (int)date('n');
            $redirectUrl = "presensi?id_kelas={$id_kelas}&id_guru={$id_guru}&id_mapel={$id_mapel}&bulan={$bulan}&tahun={$tahun}";

            // Validasi: tahun & bulan tidak boleh melebihi sekarang
            $validDate = ($tahun < $currentYear) || ($tahun == $currentYear && $bulan <= $currentMonth);
            // Validasi: guru & mapel harus sinkron
            $validMapel = $id_guru > 0 && $id_mapel > 0 && $this->guruModel->hasMapel($id_guru, $id_mapel);

            if ($id_kelas > 0 && $validDate && $validMapel) {
                $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

                foreach ($statusData as $id_murid => $days) {
                    for ($tgl = 1; $tgl <= $jumlahHari; $tgl++) {
                        $status = isset($days[$tgl]) ? $days[$tgl] : '';
                        $tanggalStr = sprintf('%04d-%02d-%02d', $tahun, $bulan, $tgl);
                        $this->presensiModel->upsertPresensi($id_murid, $id_guru, $id_mapel, $tanggalStr, $status);
                    }
                }
                Flasher::setFlash('Presensi Murid', 'disimpan', 'success');
            } else {
                Flasher::setFlash('Presensi Murid', 'gagal disimpan. Periksa kembali guru & mapel atau periode bulan/tahun', 'danger');
            }

            // Redirect kembali ke filter yang sama
            $this->redirect($redirectUrl);
        } else {
            $this->redirect('presensi');
        }
    }
}
