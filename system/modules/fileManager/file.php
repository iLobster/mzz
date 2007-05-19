<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

/**
 * file: ����� ��� ������ c �������
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.1
 */
class file extends simple
{
    protected $name = 'fileManager';

    /**
     * ��������� ������� JIP
     *
     * @return jip
     */
    public function getJip()
    {
        return $this->getJipView($this->name, $this->getFullPath(), get_class($this));
    }

    public function getFullPath()
    {
        return $this->getFolder()->getPath() . '/' . urlencode($this->getName());
    }

    public function getRealFullPath()
    {
        return systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . $this->getUploadPath() . DIRECTORY_SEPARATOR . $this->getRealname();
    }

    private function getUploadPath()
    {
        $toolkit = systemToolkit::getInstance();
        $config = $toolkit->getConfig('fileManager', $this->section);
        return $config->get('upload_path');
    }

    public function delete()
    {
        $toolkit = systemToolkit::getInstance();

        if (file_exists($file = $this->getUploadPath() . DIRECTORY_SEPARATOR . $this->getRealname())) {
            unlink($file);
        }

        $mapper = $toolkit->getMapper($this->name, 'file', $this->section);
        $mapper->delete($this->getId());
    }

    public function download()
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        $range = $request->get('HTTP_RANGE', 'string', SC_SERVER);
        if (empty($range)) {
            $this->setDownloads($this->getDownloads() + 1);
            $fileMapper = $toolkit->getMapper('fileManager', 'file', $this->section);
            $fileMapper->save($this);
        }

        set_time_limit(0);
        $fileName = $this->getRealFullPath();
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

            // @todo: � ��� �� ���� response ?
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: public, must-revalidate, max-age=0");
            header("Content-Length: " . ($size - $offset + 1));
            header("Content-Range: bytes " . $offset . "-" . $size . "/" . $fileSize);
            if (!$this->getRightHeader()) {
                header("Content-Type: application/x-octetstream");
                header("Content-Disposition: attachment; filename=\"" . $this->getName() . "\"");
            } else {
                // @todo: ������� �����������
                header("Content-Type: image/jpg");
            }
            header("Last-Modified: " . date('r', filemtime($fileName)));

            header("Content-Transfer-Encoding: binary");
            header("Accept-Ranges: bytes");
            if (ob_get_level()) {
                ob_end_clean();
            }

            $fp = fopen($fileName, "rb");
            if ($offset) {
                fseek($fp, $offset);
            }

            session_write_close();

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
        }

        throw new mzzIoException($fileName);
    }
}

?>