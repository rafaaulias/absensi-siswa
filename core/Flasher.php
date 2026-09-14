<?php

class Flasher {
    public static function setFlash($pesan, $aksi, $tipe = 'success') {
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'aksi'  => $aksi,
            'tipe'  => $tipe
        ];
    }

    public static function flash() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $pesan = htmlspecialchars($flash['pesan']);
            $aksi = htmlspecialchars($flash['aksi']);
            $tipe = htmlspecialchars($flash['tipe']);

            $bgColor = 'var(--success-bg)';
            $borderColor = '#a3e0b5';
            $textColor = 'var(--success-text)';

            if ($tipe === 'info' || $tipe === 'edit') {
                $bgColor = '#f4f4f5';
                $borderColor = '#d4d4d8';
                $textColor = '#18181b';
            } elseif ($tipe === 'danger' || $tipe === 'hapus') {
                $bgColor = 'var(--danger-bg)';
                $borderColor = '#fad2cf';
                $textColor = 'var(--danger-text)';
            }

            echo '<div class="alert alert-' . $tipe . '" style="background-color: ' . $bgColor . '; border-color: ' . $borderColor . '; color: ' . $textColor . '; margin-bottom: 20px;">
                    Data <strong>' . $pesan . '</strong> berhasil ' . $aksi . '.
                  </div>';
            
            unset($_SESSION['flash']);
        }
    }
}
