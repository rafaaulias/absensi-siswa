<?php

class MapelController extends Controller {
    private $mapelModel;

    public function __construct() {
        $this->mapelModel = new MapelModel();
    }

    public function index() {
        $data = [
            'title' => 'Data Mata Pelajaran',
            'mapel' => $this->mapelModel->getAll()
        ];
        $this->view('mapel/index', $data);
    }

    public function create() {
        $data = [
            'title' => 'Tambah Mata Pelajaran'
        ];
        $this->view('mapel/create', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_mapel = trim($_POST['nama_mapel'] ?? '');
            if (!empty($nama_mapel)) {
                $this->mapelModel->create($nama_mapel);
                Flasher::setFlash('Mata Pelajaran', 'ditambahkan', 'success');
            }
        }
        $this->redirect('mapel');
    }

    public function edit($id = null) {
        if (!$id) {
            $this->redirect('mapel');
        }
        $mapel = $this->mapelModel->getById($id);
        if (!$mapel) {
            $this->redirect('mapel');
        }
        $data = [
            'title' => 'Edit Mata Pelajaran',
            'mapel' => $mapel
        ];
        $this->view('mapel/edit', $data);
    }

    public function update($id = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $nama_mapel = trim($_POST['nama_mapel'] ?? '');
            if (!empty($nama_mapel)) {
                $this->mapelModel->update($id, $nama_mapel);
                Flasher::setFlash('Mata Pelajaran', 'diperbarui', 'info');
            }
        }
        $this->redirect('mapel');
    }

    public function delete($id = null) {
        if ($id) {
            $this->mapelModel->delete($id);
            Flasher::setFlash('Mata Pelajaran', 'dihapus', 'danger');
        }
        $this->redirect('mapel');
    }
}
