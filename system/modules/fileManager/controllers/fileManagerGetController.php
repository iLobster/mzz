<?php
/**
 * $URL$
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManagerGetController extends simpleController
{
    public function getView()
    {
        $name = $this->request->get('name', 'string', SC_PATH);

        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $file = $fileMapper->searchByPath($name);

        if (!$file) {
            return 'файл не найден';
        }

        $range = $this->request->get('HTTP_RANGE', 'string', SC_SERVER);
        if (empty($range)) {
            $file->setDownloads($file->getDownloads() + 1);
            $fileMapper->save($file);
        }

        set_time_limit(0);
        $fileName = $file->getRealFullPath();
        if (!empty($fileName) && file_exists($fileName))
        {
            $fileSize = filesize($fileName);

            $offset = 0;
            $size = $fileSize - 1;

            if (!empty($range)) {
                $range = trim($range);
                $bytes = substr($range, strpos($range, "=") + 1);
                if ($bytes) {
                    $pos = strpos($bytes, "-");
                    $offset = (int)substr($bytes, 0, $pos);
                    $size = (int)substr($bytes, $pos + 1);

                    $size = ($size < 1) ? $fileSize - 1 : $size;

                    if ($offset > $size) {
                        $offset = 0;
                        $size = $fileSize - 1;
                    }

                    if (php_sapi_name() == "cgi") {
                        header("Status: 206 Partial Content");
                    } else {
                        header("HTTP/1.1 206 Partial Content");
                    }
                }
            }

            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: public, must-revalidate, max-age=0");
            header("Content-Length: " . ($size - $offset + 1));
            header("Content-Range: bytes " . $offset . "-" . $size . "/" . $fileSize);
            header("Content-Type: application/x-octetstream");
            header("Last-Modified: " . date('r', filemtime($fileName)));
            header("Content-Disposition: attachment; filename=\"" . $file->getName() . "\"");
            header("Content-Transfer-Encoding: binary");
            header("Accept-Ranges: bytes");
            if (ob_get_level()) {
                ob_end_clean();
            }

            $fp = fopen($fileName, "rb");
            if ($offset) {
                fseek($fp, $offset);
            }

            while ($offset <= $size) {
                $bufferSize = 262144;
                if ($bufferSize + $offset > $size) {
                    $bufferSize = $size - $offset + 1;
                }
                $offset += $bufferSize;
                echo fread($fp, $bufferSize);
                if (ob_get_level()) {
                    flush();
                }
            }
            fclose($fp);
            exit();
        } else {
            return 'файл физически не существует';
        }
    }
}

?>
