<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * storage: класс для работы c данными
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class storage extends simple
{
    protected $name = 'fileManager';

    public function rename($oldname, $newname)
    {
        $newname = $this->getPath() . $this->explode($newname);

        $dir = dirname($newname);
        if (!is_dir($dir)) {
            mkdir($dir, 0666, true);
        }

        return rename($oldname, $newname);
    }

    public function delete($file)
    {
        if ($file instanceof file) {
            $name = $file->getRealname();
        } else {
            $name = $file;
        }

        if (file_exists($filename = $this->getPath() . $this->explode($name))) {
            return unlink($filename);
        }
    }

    private function explode($name)
    {
        return $name[0] . '/' . $name[1] . '/' . $name[2] . '/' . $name[3] . '/' . substr($name, 4);
    }

    public function getDownloadLink(file $file)
    {
        return $this->getWebPath() . $this->explode($file->getRealname());
    }
}

?>