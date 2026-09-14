<?php

class MapelModel extends Model {

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM mapel ORDER BY nama_mapel ASC");
    }

    public function getById($id) {
        return $this->db->fetch("SELECT * FROM mapel WHERE id_mapel = ?", [$id]);
    }

    public function create($nama_mapel) {
        return $this->db->query("INSERT INTO mapel (nama_mapel) VALUES (?)", [$nama_mapel]);
    }

    public function update($id, $nama_mapel) {
        return $this->db->query("UPDATE mapel SET nama_mapel = ? WHERE id_mapel = ?", [$nama_mapel, $id]);
    }

    public function delete($id) {
        return $this->db->query("DELETE FROM mapel WHERE id_mapel = ?", [$id]);
    }

    public function countAll() {
        $res = $this->db->fetch("SELECT COUNT(*) as total FROM mapel");
        return $res ? $res['total'] : 0;
    }
}
