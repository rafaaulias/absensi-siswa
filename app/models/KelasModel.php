<?php

class KelasModel extends Model {
    
    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM kelas ORDER BY nama_kelas ASC");
    }

    public function getById($id) {
        return $this->db->fetch("SELECT * FROM kelas WHERE id_kelas = ?", [$id]);
    }

    public function create($nama_kelas) {
        return $this->db->query("INSERT INTO kelas (nama_kelas) VALUES (?)", [$nama_kelas]);
    }

    public function update($id, $nama_kelas) {
        return $this->db->query("UPDATE kelas SET nama_kelas = ? WHERE id_kelas = ?", [$nama_kelas, $id]);
    }

    public function delete($id) {
        return $this->db->query("DELETE FROM kelas WHERE id_kelas = ?", [$id]);
    }

    public function countAll() {
        $res = $this->db->fetch("SELECT COUNT(*) as total FROM kelas");
        return $res ? $res['total'] : 0;
    }
}
