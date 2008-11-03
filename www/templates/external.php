<?php
$pathToTemplates = dirname(__FILE__);

if (isset($_GET['type']) && isset($_GET['files'])) {
    $files = explode(',', $_GET['files']);
    if ($files) {
        switch ($_GET['type']) {
            case 'js':
                header('Content-type: application/x-javascript');
                $path = $pathToTemplates . DIRECTORY_SEPARATOR . 'js';
                break;

            case 'css':
                header('Content-type: text/css');
                $path = $pathToTemplates . DIRECTORY_SEPARATOR . 'css';
                break;

            default:
                exit;
                break;
        }

        $source = generateSource($files, $path);
        echo $source;
    }
}

function generateSource(Array $files, $path) {
    $replacePatterns = array(
        '..' => ''
    );
    $source = null;
    foreach ($files as $file) {
        $filePath = $path . DIRECTORY_SEPARATOR . str_replace(array_keys($replacePatterns), $replacePatterns, $file);
        if (is_file($filePath)) {
            $source .= file_get_contents($filePath);
        }
    }

    return $source;
}

?>