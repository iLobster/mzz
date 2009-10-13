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
 * Код для получения и/или объединения (только js и css) файлов из директорий модулей и шаблонов
 *
 * @package system
 * @subpackage template
 * @version 0.1.2
 */

require_once systemConfig::$pathToSystem . '/index.php';

class externalApplication extends core
{
    protected function handle()
    {
        $request = new httpRequest();

        $type = $request->getString('type', SC_GET);
        $files = $request->getString('files', SC_GET);

        if ($type !== null && $files !== null) {
            $files = explode(',', $files);
            if ($files) {
                $mimes = array(
                    'js' => 'application/x-javascript',
                    'css' => 'text/css',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'jpg' => 'image/jpeg',
                    'html' => 'text/html',
                    'htm' => 'text/html');
                $source = null;

                if (isset($mimes[$type])) {
                    header('Content-Type: ' . $mimes[$type]);
                    $source = $this->generateSource($files, $request->getHeaders());
                }

                echo $source;
                exit();
            }
        }
    }

    protected function composeResolvers()
    {
        require_once systemConfig::$pathToSystem . '/resolver/init.php';
        require_once systemConfig::$pathToSystem . '/resolver/templateMediaResolver.php';
        require_once systemConfig::$pathToSystem . '/resolver/moduleMediaResolver.php';
        require_once systemConfig::$pathToSystem . '/resolver/extensionBasedModuleMediaResolver.php';
        require_once systemConfig::$pathToSystem . '/core/fileLoader.php';

        $baseresolver = new compositeResolver();
        $baseresolver->addResolver(new fileResolver(systemConfig::$pathToApplication . '/*'));
        $baseresolver->addResolver(new fileResolver(systemConfig::$pathToSystem . '/*'));

        $resolver = new compositeResolver();
        $resolver->addResolver(new templateMediaResolver($baseresolver));
        $resolver->addResolver(new moduleMediaResolver($baseresolver));
        $resolver->addResolver(new extensionBasedModuleMediaResolver($baseresolver));
        $resolver->addResolver(new classFileResolver($baseresolver));

        if (function_exists('external_callback')) {
            external_callback($resolver, $baseresolver);
        }

        return new cachingResolver($resolver, 'resolver.media.cache');
    }

    protected function loadCommonFiles()
    {
        fileLoader::load('exceptions/init');
        errorDispatcher::setDispatcher(new errorDispatcher());

        fileLoader::load('service/arrayDataspace');

        fileLoader::load('request/init');
        fileLoader::load('toolkit/init');
    }

    private function generateSource(Array $files, $headers)
    {
        $fileNameReplacePatterns = array(
            '..' => '');
        $source = null;
        $filemtime = null;

        foreach ($files as $file) {
            $file = preg_replace('![^a-z\d_\-/.]!i', '', $file);

            $file = str_replace(array_keys($fileNameReplacePatterns), $fileNameReplacePatterns, $file);

            $filePath = null;

            try {
                $filePath = fileLoader::resolve($file);
            } catch (mzzIoException $e) {
                // если в обычных директориях не найден - ищем в simple
                try {
                    $filePath = fileLoader::resolve('simple/' . $file);
                } catch (mzzIoException $e) {
                    continue;
                }
            }

            if (is_readable($filePath)) {
                $currentFileTime = filemtime($filePath);
                if ($currentFileTime > $filemtime) {
                    $filemtime = $currentFileTime;
                }
                $source .= file_get_contents($filePath);
            }
        }

        if (is_null($filemtime)) {
            header("HTTP/1.1 404 Not Found");
            header('Content-Type: text/html');
            exit();
        }

        $age = 86400 * 30 * 6;

        header("Pragma: public");
        header("Cache-Control: public, must-revalidate, max-age=" . $age);

        if ($files && $filemtime) {
            $last_modified = gmdate("D, d M Y H:i:s", $filemtime);
            header('Last-Modified: ' . $last_modified . ' GMT');
            header('Expires: ' . gmdate("D, d M Y H:i:s", time() + $age) . ' GMT');
            $etag = $this->generateEtag($files, $filemtime);
            header('ETag: ' . $etag);
        }

        $etag_match = null;
        $time_match = null;

        if (isset($headers['If-None-Match'])) {
            $etag_match = strpos($headers['If-None-Match'], $etag) !== false;
        }

        if (isset($headers['If-Modified-Since'])) {
            $modified_since = strtotime($headers['If-Modified-Since']);

            $time_match = false;
            if ($modified_since <= time() && is_int($modified_since) && $modified_since >= $filemtime) {
                $time_match = true;
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

    private function generateEtag(Array $files, $filemtime)
    {
        $etag = md5(implode(',', $files) . $filemtime);

        $etag = substr_replace($etag, '-', 8, 0);
        $etag = substr_replace($etag, '-', 13, 0);
        $etag = substr_replace($etag, '-', 18, 0);
        $etag = substr_replace($etag, '-', 23, 0);

        return $etag;
    }
}

$application = new externalApplication();
$application->run();

?>