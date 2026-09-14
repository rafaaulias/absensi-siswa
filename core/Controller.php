<?php

class Controller {
    public function view($view, $data = []) {
        extract($data);
        
        $viewFile = __DIR__ . '/../app/views/' . $view . '.php';
        $headerFile = __DIR__ . '/../app/views/layouts/header.php';
        $footerFile = __DIR__ . '/../app/views/layouts/footer.php';

        if (file_exists($headerFile)) {
            require_once $headerFile;
        }

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "View <strong>{$view}</strong> tidak ditemukan!";
        }

        if (file_exists($footerFile)) {
            require_once $footerFile;
        }
    }

    public function redirect($url) {
        $baseUrl = BASEURL;
        header("Location: {$baseUrl}/{$url}");
        exit;
    }
}
