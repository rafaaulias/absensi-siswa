<?php

class GuruController extends Controller {
    private $guruModel;
    private $mapelModel;

    public function __construct() {
        $this->guruModel = new GuruModel();
        $this->mapelModel = new MapelModel();
    }

    public function index() {
        $data = [
            'title' => 'Data Guru',
            'guru' => $this->guruModel->getAll()
        ];
        $this->view('guru/index', $data);
    }

    public function create() {
        $data = [
            'title' => 'Tambah Guru',
            'mapel' => $this->mapelModel->getAll()
        ];
        $this->view('guru/create', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_guru = trim($_POST['nama_guru'] ?? '');
            $id_mapels = array_map('intval', (array)($_POST['id_mapel'] ?? []));

            if (!empty($nama_guru)) {
                $this->guruModel->create($nama_guru, $id_mapels);
                Flasher::setFlash('Guru', 'ditambahkan', 'success');
            }
        }
        $this->redirect('guru');
    }

    public function edit($id = null) {
        if (!$id) {
            $this->redirect('guru');
        }
        $guru = $this->guruModel->getById($id);
        if (!$guru) {
            $this->redirect('guru');
        }
        $data = [
            'title' => 'Edit Guru',
            'guru' => $guru,
            'mapel' => $this->mapelModel->getAll()
        ];
        $this->view('guru/edit', $data);
    }

    public function update($id = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $nama_guru = trim($_POST['nama_guru'] ?? '');
            $id_mapels = array_map('intval', (array)($_POST['id_mapel'] ?? []));

            if (!empty($nama_guru)) {
                $this->guruModel->update($id, $nama_guru, $id_mapels);
                Flasher::setFlash('Guru', 'diperbarui', 'info');
            }
        }
        $this->redirect('guru');
    }

    public function delete($id = null) {
        if ($id) {
            $this->guruModel->delete($id);
            Flasher::setFlash('Guru', 'dihapus', 'danger');
        }
        $this->redirect('guru');
    }
}
