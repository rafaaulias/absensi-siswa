<?php

class MuridController extends Controller {
    private $muridModel;
    private $kelasModel;

    public function __construct() {
        $this->muridModel = new MuridModel();
        $this->kelasModel = new KelasModel();
    }

    public function index() {
        $selectedKelas = (int)($_GET['kelas'] ?? 0);
        $data = [
            'title' => 'Data Murid',
            'murid' => $selectedKelas > 0 ? $this->muridModel->getByKelas($selectedKelas) : $this->muridModel->getAll(),
            'kelas' => $this->kelasModel->getAll(),
            'selectedKelas' => $selectedKelas
        ];
        $this->view('murid/index', $data);
    }

    public function create() {
        $data = [
            'title' => 'Tambah Murid',
            'kelas' => $this->kelasModel->getAll()
        ];
        $this->view('murid/create', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $no_absen = (int)($_POST['no_absen'] ?? 1);
            $nama_murid = trim($_POST['nama_murid'] ?? '');
            $id_kelas = (int)($_POST['id_kelas'] ?? 0);
            if (!empty($nama_murid) && $id_kelas > 0) {
                $this->muridModel->create($no_absen, $nama_murid, $id_kelas);
                Flasher::setFlash('Murid', 'ditambahkan', 'success');
            }
        }
        $this->redirect('murid');
    }

    public function edit($id = null) {
        if (!$id) {
            $this->redirect('murid');
        }
        $murid = $this->muridModel->getById($id);
        if (!$murid) {
            $this->redirect('murid');
        }
        $data = [
            'title' => 'Edit Murid',
            'murid' => $murid,
            'kelas' => $this->kelasModel->getAll()
        ];
        $this->view('murid/edit', $data);
    }

    public function update($id = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $no_absen = (int)($_POST['no_absen'] ?? 1);
            $nama_murid = trim($_POST['nama_murid'] ?? '');
            $id_kelas = (int)($_POST['id_kelas'] ?? 0);
            if (!empty($nama_murid) && $id_kelas > 0) {
                $this->muridModel->update($id, $no_absen, $nama_murid, $id_kelas);
                Flasher::setFlash('Murid', 'diperbarui', 'info');
            }
        }
        $this->redirect('murid');
    }

    public function delete($id = null) {
        if ($id) {
            $this->muridModel->delete($id);
            Flasher::setFlash('Murid', 'dihapus', 'danger');
        }
        $this->redirect('murid');
    }
}
