<?php

class KelasController extends Controller {
    private $kelasModel;

    public function __construct() {
        $this->kelasModel = new KelasModel();
    }

    public function index() {
        $data = [
            'title' => 'Data Kelas',
            'kelas' => $this->kelasModel->getAll()
        ];
        $this->view('kelas/index', $data);
    }

    public function create() {
        $data = [
            'title' => 'Tambah Kelas'
        ];
        $this->view('kelas/create', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_kelas = trim($_POST['nama_kelas'] ?? '');
            if (!empty($nama_kelas)) {
                $this->kelasModel->create($nama_kelas);
                Flasher::setFlash('Kelas', 'ditambahkan', 'success');
            }
        }
        $this->redirect('kelas');
    }

    public function edit($id = null) {
        if (!$id) {
            $this->redirect('kelas');
        }
        $kelas = $this->kelasModel->getById($id);
        if (!$kelas) {
            $this->redirect('kelas');
        }
        $data = [
            'title' => 'Edit Kelas',
            'kelas' => $kelas
        ];
        $this->view('kelas/edit', $data);
    }

    public function update($id = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $nama_kelas = trim($_POST['nama_kelas'] ?? '');
            if (!empty($nama_kelas)) {
                $this->kelasModel->update($id, $nama_kelas);
                Flasher::setFlash('Kelas', 'diperbarui', 'info');
            }
        }
        $this->redirect('kelas');
    }

    public function delete($id = null) {
        if ($id) {
            $this->kelasModel->delete($id);
            Flasher::setFlash('Kelas', 'dihapus', 'danger');
        }
        $this->redirect('kelas');
    }
}
