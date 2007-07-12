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

fileLoader::load('simple/simpleForTree');

/**
 * folder: ����� ��� ������ c �������
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.3
 */

class folder extends simpleForTree
{
    protected $name = 'fileManager';
    protected $mapper;

    /**
     * �����������
     *
     * @param object $mapper
     * @param array $map
     */
    public function __construct($mapper, Array $map)
    {
        parent::__construct($mapper, $map);
        $this->treeFields = new arrayDataspace();
    }

    /**
     * ���������� �������, ����������� � ������ �����
     *
     * @return array
     */
    public function getItems()
    {
        if (!$this->fields->exists('items')) {
            $this->fields->set('items', $this->mapper->getItems($this->getId()));
        }
        return $this->fields->get('items');
    }

    public function getTreeParent()
    {
        return $this->mapper->getTreeParent($this->getParent());
    }

    public function getJip()
    {
        return $this->getJipView($this->name, $this->getPath(), get_class($this));
    }

    public function upload($upload_name, $name = null, $path = null)
    {
        if (is_null($path)) {
            $config = systemToolkit::getInstance()->getConfig('fileManager', $this->section);
            $path = $config->get('upload_path');
        }

        if (!isset($_FILES[$upload_name])) {
            if (is_file($upload_name)) {
                $info = array('name' => basename($upload_name), 'size' => filesize($upload_name), 'tmp_name' => $upload_name);
            } else {
                throw new mzzRuntimeException('������� ���� ��� ��������');
            }
        } else {
            $info = array('name' => $_FILES[$upload_name]['name'], 'size' => $_FILES[$upload_name]['size'], 'tmp_name' => $_FILES[$upload_name]['tmp_name']);
        }

        if (empty($name)) {
            $name = $info['name'];
        }

        $name = preg_replace('/[^a-z�-�0-9!_. \-\[\]()]/i', '', $name);

        $criteria = new criteria();
        $criteria->add('folder_id', $this->getId())->add('name', $name);

        $fileMapper = systemToolkit::getInstance()->getMapper('fileManager', 'file', $this->section);
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
            // �������� ��� ��� ����������
            $name_wo_ext = $name; $ext = '';
            if ($dot = strrpos($name, '.')) {
                $name_wo_ext = substr($name, 0, $dot);
                $ext = substr($name, $dot + 1);
            }
        }
        if ($file) {
            // ���� ��� ����� ������� ��������� ��� �����: filename*.ext
            $criterion = new criterion('name', $name, criteria::NOT_EQUAL);
            $criterion->addAnd(new criterion('name', $name_wo_ext . '\_%' . ($ext ? '.' . $ext : ''), criteria::LIKE));

            $criteria = new criteria();
            $criteria->add('folder_id', $this->getId())->add($criterion);
            $criteria->setOrderByFieldAsc('name');
            $files = $fileMapper->searchAllByCriteria($criteria);

            // ���� ������ "������" � ��������� ������ � ����������� �������
            $i = 2;
            foreach ($files as $file) {
                if (strpos($file->getName(), $name_wo_ext . '_' . $i) !== 0) {
                    break;
                }
                $i++;
            }

            // ��������� � ����� ��������� ������
            $name = substr_replace($name, $name_wo_ext . '_' . $i, 0, strlen($name_wo_ext));
            $file = false;
        }

        if ($filesize = $this->getFilesize()) {
            $size_in_mb = round($info['size'] / 1024 / 1024, 3);
            if ($size_in_mb > $filesize) {
                throw new mzzRuntimeException('����������� �� �������� �����: ' . $filesize . ' ��. � ������������ ����� ������: ' . $size_in_mb . ' ��');
            }
        }

        if ($exts = $this->getExts()) {
            $exts = explode(';', $exts);

            if (!in_array($ext, $exts)) {
                throw new mzzRuntimeException('����������� �� ���������� �����: ' . $this->getExts() . '. � ������������ ����� ����������: "' . $ext . '"');
            }
        }

        while (true) {
            try {
                $file = $fileMapper->create();
                $file->setRealname($realname = md5(microtime(true)));
                $file->setName($name);
                $file->setExt($ext);
                $file->setSize($info['size']);
                $file->setFolder($this);
                $fileMapper->save($file);
                if (rename($info['tmp_name'], $path . '/' . $file->getRealname())) {
                    break;
                }

                throw new mzzRuntimeException('���� "' . $info['tmp_name'] . '" �  ��� ���������  � ������� "' . $path . '/' . $file->getRealname() . '"');
            } catch (PDOException $e) {
            }
        }

        return $file;
    }
}

?>