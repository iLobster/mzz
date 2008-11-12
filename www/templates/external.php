<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * Генератор объединённых js-файлов
 *
 * @package system
 * @subpackage template
 * @version 0.1
 */

$pathToTemplates = dirname(__FILE__);
if (isset($_GET['type']) && isset($_GET['files'])) {
    $headers = apache_request_headers();

    $files = explode(',', $_GET['files']);
    if ($files) {
        switch ($_GET['type']) {
            case 'js':
                header('Content-type: application/x-javascript');
                $source = generateSource($files, $pathToTemplates . DIRECTORY_SEPARATOR . 'js', 'js', $headers);
                break;

            case 'css':
                header('Content-type: text/css');
                $source = generateSource($files, $pathToTemplates . DIRECTORY_SEPARATOR . 'css', 'css');
                break;

            default:
                $source = null;
                break;
        }

        echo $source;
        exit();
    }
}

function generateSource(Array $files, $path, $validExt, $headers)
{
    $fileNameReplacePatterns = array('..' => '');
    $source = null;
    $filemtime = null;
    foreach ($files as $file) {
        $file = str_replace(array_keys($fileNameReplacePatterns), $fileNameReplacePatterns, $file);
        $ext = substr(strrchr($file, '.'), 1);
        if ($ext == $validExt) {
            $filePath = $path . DIRECTORY_SEPARATOR . $file;
            if (is_file($filePath) && is_readable($filePath)) {
                $currentFileTime = filemtime($filePath);
                if ($currentFileTime > $filemtime) {
                    $filemtime = $currentFileTime;
                }
                $source .= file_get_contents($filePath);
            }
        }
    }

    if ($files && $filemtime) {
        $last_modified = gmdate("D, d M Y H:i:s", $filemtime);
        header('Last-Modified: ' . $last_modified . ' GMT');
        header('Expires: ' . gmdate("D, d M Y H:i:s", time() + 86400 * 30 * 6) . ' GMT');
        $etag = generateEtag($files, $filemtime);
        header('ETag: ' . $etag);
    }

    $etag_match = null;
    $time_match = null;

    if (isset($headers['If-None-Match'])) {
        $etag_match = $headers['If-None-Match'] == $etag;
    }

    if (isset($headers['If-Modified-Since'])) {
        $modified_since = strtotime($headers['If-Modified-Since']);

        $time_match = false;
        if ($modified_since <= time() && is_int($modified_since) && $modified_since >= $filemtime) {
            $changed = $time_match = true;
        }
    }

    $changed = false;
    if (is_null($etag_match) && is_null($time_match)) {
        $changed = true;
    } elseif ($etag_match === false || $time_match === false) {
        $changed = true;
    }

    if (!$changed) {
        header("HTTP/1.1 304 Not Modified");
        $source = '';
    }

    return $source;
}

function generateEtag(Array $files, $filemtime)
{
    $etag = md5(implode(',', $files) . $filemtime);

    $etag = substr_replace($etag, '-', 8, 0);
    $etag = substr_replace($etag, '-', 13, 0);
    $etag = substr_replace($etag, '-', 18, 0);
    $etag = substr_replace($etag, '-', 23, 0);

    return $etag;
}

?>