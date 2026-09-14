<?php

class MuridModel extends Model {

    public function getAll() {
        return $this->db->fetchAll(
            "SELECT m.*, k.nama_kelas 
             FROM murid m 
             LEFT JOIN kelas k ON m.id_kelas = k.id_kelas 
             ORDER BY k.nama_kelas ASC, m.no_absen ASC, m.nama_murid ASC"
        );
    }

    public function getByKelas($id_kelas) {
        return $this->db->fetchAll(
            "SELECT m.*, k.nama_kelas 
             FROM murid m 
             LEFT JOIN kelas k ON m.id_kelas = k.id_kelas 
             WHERE m.id_kelas = ? 
             ORDER BY m.no_absen ASC, m.nama_murid ASC", 
            [(int)$id_kelas]
        );
    }

    public function getById($id) {
        return $this->db->fetch("SELECT * FROM murid WHERE id_murid = ?", [$id]);
    }

    public function create($no_absen, $nama_murid, $id_kelas) {
        return $this->db->query(
            "INSERT INTO murid (no_absen, nama_murid, id_kelas) VALUES (?, ?, ?)", 
            [(int)$no_absen, $nama_murid, (int)$id_kelas]
        );
    }

    public function update($id, $no_absen, $nama_murid, $id_kelas) {
        return $this->db->query(
            "UPDATE murid SET no_absen = ?, nama_murid = ?, id_kelas = ? WHERE id_murid = ?", 
            [(int)$no_absen, $nama_murid, (int)$id_kelas, (int)$id]
        );
    }

    public function delete($id) {
        return $this->db->query("DELETE FROM murid WHERE id_murid = ?", [$id]);
    }

    public function countAll() {
        $res = $this->db->fetch("SELECT COUNT(*) as total FROM murid");
        return $res ? $res['total'] : 0;
    }
}
