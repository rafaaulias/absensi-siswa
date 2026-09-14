<?php

class DashboardController extends Controller {

    public function index() {
        $kelasModel = new KelasModel();
        $guruModel = new GuruModel();
        $mapelModel = new MapelModel();
        $muridModel = new MuridModel();

        $data = [
            'title' => 'Dashboard Beranda',
            'total_kelas' => $kelasModel->countAll(),
            'total_guru' => $guruModel->countAll(),
            'total_mapel' => $mapelModel->countAll(),
            'total_murid' => $muridModel->countAll(),
        ];

        $this->view('dashboard/index', $data);
    }
}
