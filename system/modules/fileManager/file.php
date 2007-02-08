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
 * file: класс для работы c данными
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */
class file extends simple
{
    protected $name = 'fileManager';

    /**
     * Получение объекта JIP
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
        return $this->getUploadPath() . DIRECTORY_SEPARATOR . $this->getRealname();
    }

    private function getUploadPath()
    {
        $toolkit = systemToolkit::getInstance();
        $config = $toolkit->getConfig('fileManager');
        return $config->get('upload_path');
    }

    public function delete()
    {
        $toolkit = systemToolkit::getInstance();

        if (file_exists($file = $this->getUploadPath() . DIRECTORY_SEPARATOR . $this->getRealname())) {
            unlink($file);
        }

        $mapper = $toolkit->getMapper($this->name, 'file');
        $mapper->delete($this->getId());
    }
}

?>