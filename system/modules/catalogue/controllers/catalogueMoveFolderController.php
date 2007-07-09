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
 * catalogueMoveFolderController: ���������� ��� ������ moveFolder ������ catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueMoveFolderController extends simpleController
{
    protected function getView()
    {
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');
        $path = $this->request->get('name', 'string', SC_PATH);

        $folder = $catalogueFolderMapper->searchByPath($path);
        if (!$folder) {
            return $catalogueFolderMapper->get404()->run();
        }

        $folders = $catalogueFolderMapper->getTreeExceptNode($folder);

        if (sizeof($folders) <= 1) {
            return '���������� ���������� ������ �������';
        }

        $select = array();
        foreach ($folders as $key => $val) {
            $select[$key] = $val->getPath();
        }

        $validator = new formValidator();
        $validator->add('required', 'dest', '���������� ������� ������� ����������');

        if ($validator->validate()) {
            $dest = $this->request->get('dest', 'integer', SC_POST);
            if ($dest) {
                $destFolder = $catalogueFolderMapper->searchByParentId($dest);

                if (!$destFolder) {
                    return '������� ���������� �� ������';
                }

                if (!isset($folders[$dest])) {
                    return '������ ��������� ������� �� ��������� ��������';
                }

                $duplicate = $catalogueFolderMapper->searchByPath($destFolder->getPath() . '/' . $folder->getName());
                if (!$duplicate) {
                    $result = $catalogueFolderMapper->move($folder, $destFolder);

                    if ($result) {
                        return jipTools::redirect();
                    }

                    return '���������� ����������� ������ �����������';

                } else {
                    return '� ��������� �������� ���������� ��� ���������� ������� � ����� ������';
                }
            }
        }

        $url = new url('withAnyParam');
        $url->setSection($this->request->getSection());
        $url->setAction($this->request->getAction());
        $url->addParam('name', $folder->getPath());

        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('folder', $folder);
        $this->smarty->assign('select', $select);
        return $this->smarty->fetch('catalogue/moveFolder.tpl');
    }
}

?>