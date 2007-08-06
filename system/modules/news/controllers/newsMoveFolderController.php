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

fileLoader::load('forms/validators/formValidator');

/**
 * newsMoveFolderController: ���������� ��� ������ moveFolder ������ news
 *
 * @package modules
 * @subpackage news
 * @version 0.2
 */

class newsMoveFolderController extends simpleController
{
    protected function getView()
    {
        $folderMapper = $this->toolkit->getMapper('news', 'newsFolder');
        $path = $this->request->get('name', 'string', SC_PATH);
        $dest = $this->request->get('dest', 'integer', SC_POST);

        $folder = $folderMapper->searchByPath($path);
        if (!$folder) {
            $controller = new messageController('������� �� ������');
            return $controller->run();
        }

        $folders = $folderMapper->getTreeExceptNode($folder);
        if (sizeof($folders) <= 1) {
            $controller = new messageController('���������� ���������� ������ �������');
            return $controller->run();
        }

        $validator = new formValidator();

        $validator->add('required', 'dest', '������������ ��� ���������� ����');
        $validator->add('callback', 'dest', '������� ���������� �� ����������', array('checkDestNewsFolderExists', $folderMapper));
        $validator->add('callback', 'dest', '� �������� ���������� ��� ���� ������� � ����� ������', array('checkUniqueNewsFolderName', $folderMapper, $folder));
        $validator->add('callback', 'dest', '������ ��������� ������� �� ��������� ��������', array('checkDestNewsFolderIsNotChildren', $folders));

        $errors = $validator->getErrors();

        if ($validator->validate()) {
            $destFolder = $folderMapper->searchById($dest);
            $result = $folderMapper->move($folder, $destFolder);
            if ($result) {
                /*$url = new url('withAnyParam');
                $url->add('action', 'list');
                $url->add('name', $folder->getPath());
                return jipTools::redirect($url->get());*/
                // @todo: ����� ��� ��������� �������, ������ ����� ������� ������� ������ �������� ��� �������� �����
                return jipTools::redirect();
            }
            $errors->set('dest', '���������� ����������� ��������� �����������');
        }

        $url = new url('withAnyParam');
        $url->setAction('moveFolder');
        $url->add('name', $folder->getPath());

        $dests = array();
        $styles = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getTitle();
            $styles[$val->getId()] = 'padding-left: ' . ($val->getTreeLevel() * 15) . 'px;';
        }

        $this->smarty->assign('folder', $folder);
        $this->smarty->assign('dests', $dests);
        $this->smarty->assign('styles', $styles);
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $errors);
        return $this->smarty->fetch('news/moveFolder.tpl');
    }
}

function checkUniqueNewsFolderName($id, $folderMapper, $folder)
{
    if ($folder->getTreeParent()->getId() == $id) {
        return true;
    }
    $destFolder = $folderMapper->searchById($id);
    $someFolder = $folderMapper->searchByPath($destFolder->getPath() . '/' . $folder->getName());
    return empty($someFolder);
}

function checkDestNewsFolderExists($id, $folderMapper)
{
    $destFolder = $folderMapper->searchById($id);
    return !empty($destFolder);
}

function checkDestNewsFolderIsNotChildren($id, $folders)
{
    return isset($folders[$id]);
}
?>