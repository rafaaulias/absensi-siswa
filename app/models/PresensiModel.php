<?php

class PresensiModel extends Model {

    /**
     * Mengambil data presensi bulanan dalam format array [id_murid][tgl] => status
     */
    public function getPresensiBulan($id_kelas, $id_guru, $id_mapel, $bulan, $tahun) {
        $startDate = sprintf('%04d-%02d-01', $tahun, $bulan);
        $endDate = sprintf('%04d-%02d-%02d', $tahun, $bulan, cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun));

        $sql = "SELECT p.id_murid, DAY(p.tanggal) as tgl, p.status 
                FROM presensi p
                JOIN murid m ON p.id_murid = m.id_murid
                WHERE m.id_kelas = ? AND p.id_guru = ? AND p.id_mapel = ? 
                AND p.tanggal BETWEEN ? AND ?";

        $rows = $this->db->fetchAll($sql, [$id_kelas, $id_guru, $id_mapel, $startDate, $endDate]);

        $matrix = [];
        foreach ($rows as $row) {
            $matrix[$row['id_murid']][$row['tgl']] = $row['status'];
        }

        return $matrix;
    }

    /**
     * Simpan / Update data presensi per sel (UPSERT)
     */
    public function upsertPresensi($id_murid, $id_guru, $id_mapel, $tanggal, $status) {
        $status = trim($status);
        
        if (in_array($status, ['H', 'I', 'S', 'A'])) {
            $sql = "INSERT INTO presensi (id_murid, id_guru, id_mapel, tanggal, status) 
                    VALUES (?, ?, ?, ?, ?) 
                    ON DUPLICATE KEY UPDATE status = VALUES(status)";
            return $this->db->query($sql, [$id_murid, $id_guru, $id_mapel, $tanggal, $status]);
        } else {
            // Jika dikosongkan, hapus data presensi untuk kombinasi ini jika sudah ada
            $sql = "DELETE FROM presensi WHERE id_murid = ? AND id_guru = ? AND id_mapel = ? AND tanggal = ?";
            return $this->db->query($sql, [$id_murid, $id_guru, $id_mapel, $tanggal]);
        }
    }
}
