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
        return rename($oldname, $this->getPath() . $newname);
    }

    public function delete($file)
    {
        file_put_contents('c:/q', $this->getPath() . $file->getRealname());
        if (file_exists($filename = $this->getPath() . $file->getRealname())) {
            return unlink($filename);
        }
    }
}

?>