<?php
if (isset($_GET['type']) && isset($_GET['files'])) {
    $files = explode(',', $_GET['files']);
    if ($files) {
        switch ($_GET['type']) {
            case 'js':
                $jsSource = null;
                foreach ($files as $file) {
                    $filePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . $file;
                    if (is_file($filePath)) {
                        $jsSource .= file_get_contents($filePath);
                    }
                }

                echo $jsSource;
                break;

            case 'css':
                $cssSource = null;
                foreach ($files as $file) {
                    $filePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . $file;
                    if (is_file($filePath)) {
                        $cssSource .= file_get_contents($filePath);
                    }
                }

                echo $cssSource;
                break;
        }
    }
}
?>