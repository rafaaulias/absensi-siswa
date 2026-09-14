<?php

class GuruModel extends Model {

    public function getAll() {
        $guru = $this->db->fetchAll("SELECT * FROM guru ORDER BY nama_guru ASC");
        return $this->attachMapels($guru);
    }

    public function getById($id) {
        $guru = $this->db->fetch("SELECT * FROM guru WHERE id_guru = ?", [$id]);
        if (!$guru) {
            return null;
        }
        $guru['mapels'] = $this->getMapelByGuru($id);
        $guru['mapel_ids'] = array_column($guru['mapels'], 'id_mapel');
        return $guru;
    }

    public function getMapelByGuru($id_guru) {
        return $this->db->fetchAll(
            "SELECT m.id_mapel, m.nama_mapel
             FROM guru_mapel gm
             JOIN mapel m ON gm.id_mapel = m.id_mapel
             WHERE gm.id_guru = ?
             ORDER BY m.nama_mapel ASC",
            [$id_guru]
        );
    }

    public function hasMapel($id_guru, $id_mapel) {
        $res = $this->db->fetch(
            "SELECT COUNT(*) as total FROM guru_mapel WHERE id_guru = ? AND id_mapel = ?",
            [(int)$id_guru, (int)$id_mapel]
        );
        return $res && (int)$res['total'] > 0;
    }

    private function attachMapels($guruList) {
        if (empty($guruList)) {
            return [];
        }
        $ids = array_column($guruList, 'id_guru');
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $rows = $this->db->fetchAll(
            "SELECT gm.id_guru, m.id_mapel, m.nama_mapel
             FROM guru_mapel gm
             JOIN mapel m ON gm.id_mapel = m.id_mapel
             WHERE gm.id_guru IN ($placeholders)
             ORDER BY m.nama_mapel ASC",
            $ids
        );

        $grouped = [];
        foreach ($rows as $row) {
            $grouped[$row['id_guru']][] = $row;
        }

        foreach ($guruList as &$g) {
            $g['mapels'] = $grouped[$g['id_guru']] ?? [];
            $g['mapel_ids'] = array_column($g['mapels'], 'id_mapel');
        }
        return $guruList;
    }

    public function create($nama_guru, $id_mapels = []) {
        $this->db->query("INSERT INTO guru (nama_guru) VALUES (?)", [$nama_guru]);
        $id_guru = $this->db->lastInsertId();
        $this->syncMapels($id_guru, $id_mapels);
        return $id_guru;
    }

    public function update($id, $nama_guru, $id_mapels = []) {
        $this->db->query("UPDATE guru SET nama_guru = ? WHERE id_guru = ?", [$nama_guru, $id]);
        $this->syncMapels($id, $id_mapels);
    }

    private function syncMapels($id_guru, $id_mapels) {
        $this->db->query("DELETE FROM guru_mapel WHERE id_guru = ?", [$id_guru]);
        foreach ((array)$id_mapels as $id_mapel) {
            $id_mapel = (int)$id_mapel;
            if ($id_mapel > 0) {
                $this->db->query(
                    "INSERT INTO guru_mapel (id_guru, id_mapel) VALUES (?, ?)",
                    [$id_guru, $id_mapel]
                );
            }
        }
    }

    public function delete($id) {
        return $this->db->query("DELETE FROM guru WHERE id_guru = ?", [$id]);
    }

    public function countAll() {
        $res = $this->db->fetch("SELECT COUNT(*) as total FROM guru");
        return $res ? $res['total'] : 0;
    }
}
