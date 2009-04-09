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
 * folder: класс для работы c данными
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.2
 */

class folder extends entity
{
    protected $name = 'fileManager';
    protected $mapper;
    protected $storage;

    public function getJip()
    {
        return parent::__call('getJip', array(1, $this->getTreePath()));
    }

    public function upload($upload_name, $name = null)
    {
        if (!isset($_FILES[$upload_name])) {
            if (is_file($upload_name)) {
                $info = array('name' => basename($upload_name), 'size' => filesize($upload_name), 'tmp_name' => $upload_name);
            } else {
                throw new mzzRuntimeException('Укажите файл для загрузки');
            }
        } else {
            $info = array('name' => $_FILES[$upload_name]['name'], 'size' => $_FILES[$upload_name]['size'], 'tmp_name' => $_FILES[$upload_name]['tmp_name']);
        }

        if (empty($name)) {
            $name = $info['name'];
        }

        $name = preg_replace('/[^a-zа-я0-9!_. \-\[\]()]/ui', '', $name);

        $criteria = new criteria();
        $criteria->add('folder_id', $this->getId())->add('name', $name);

        $fileMapper = systemToolkit::getInstance()->getMapper('fileManager', 'file');
        $file = $fileMapper->searchOneByCriteria($criteria);

        $exts = $this->getExts();

        if (strlen($exts)) {
            $exts = explode(';', $exts);
        } else {
            $exts = $fileMapper->getExclusionExtensions();
        }

        array_map('trim', $exts);
        usort($exts, create_function('$a,$b', 'return strlen($a) < strlen($b);'));

        foreach ($exts as $ext) {
            $pos = strrpos(strtolower($name), strtolower($ext));
            if ($pos !== false && strlen($ext) + $pos == strlen($name)) {
                $name_wo_ext = substr($name, 0, -strlen($ext) - 1);
                break;
            }
        }

        if (!isset($name_wo_ext)) {
            // получаем имя без расширения
            $name_wo_ext = $name; $ext = '';
            if ($dot = strrpos($name, '.')) {
                $name_wo_ext = substr($name, 0, $dot);
                $ext = substr($name, $dot + 1);
            }
        }
        if ($file) {
            // ищем все файлы которые подпадают под маску: filename*.ext
            $criterion = new criterion('name', $name, criteria::NOT_EQUAL);
            $criterion->addAnd(new criterion('name', $name_wo_ext . '\_%' . ($ext ? '.' . $ext : ''), criteria::LIKE));

            $criteria = new criteria();
            $criteria->add('folder_id', $this->getId())->add($criterion);
            $criteria->setOrderByFieldAsc('name');
            $files = $fileMapper->searchAllByCriteria($criteria);

            // ищем первый "пробел" в нумерации файлов с одинаковыми именами
            $i = 2;
            foreach ($files as $file) {
                if (strpos($file->getName(), $name_wo_ext . '_' . $i) !== 0) {
                    break;
                }
                $i++;
            }

            // добавляем к имени найденный индекс
            $name = substr_replace($name, $name_wo_ext . '_' . $i, 0, strlen($name_wo_ext));
            $file = false;
        }

        if ($filesize = $this->getFilesize()) {
            $size_in_mb = round($info['size'] / 1024 / 1024, 3);
            if ($size_in_mb > $filesize) {
                throw new mzzRuntimeException('Ограничение на загрузку файла: ' . $filesize . ' Мб. У загружаемого файла размер: ' . $size_in_mb . ' Мб');
            }
        }

        if ($exts = $this->getExts()) {
            $exts = explode(';', $exts);

            if (!in_array($ext, $exts)) {
                throw new mzzRuntimeException('Ограничение на расширение файла: ' . $this->getExts() . '. У загружаемого файла расширение: "' . $ext . '"');
            }
        }

        $storage = $this->getStorage();

        while (true) {
            try {
                $file = $fileMapper->create();
                $file->setRealname($realname = md5(microtime(true)) . '.' . $ext);
                $file->setName($name);
                $file->setExt($ext);
                $file->setSize($info['size']);
                $file->setFolder($this);
                $file->setStorage($storage);
                $fileMapper->save($file);

                if ($storage->rename($info['tmp_name'], $file->getRealname())) {
                    break;
                }

                throw new mzzRuntimeException('Файл "' . $info['tmp_name'] . '" не был перемещён  в каталог "' . $storage->getPath() . '"');
            } catch (PDOException $e) {
            }
        }

        return $file;
    }
}

?>