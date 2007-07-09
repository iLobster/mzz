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
 * pageSaveFolderController: ���������� ��� ������ saveFolder ������ page
 *
 * @package modules
 * @subpackage page
 * @version 0.2
 */
class pageSaveFolderController extends simpleController
{
    protected function getView()
    {
        $path = $this->request->get('name', 'string', SC_PATH);
        $action = $this->request->getAction();
        $isEdit = ($action == 'editFolder');

        $folderMapper = $this->toolkit->getMapper('page', 'pageFolder');
        $targetFolder = $folderMapper->searchByPath($path);

        if (empty($targetFolder)) {
            return $folderMapper->get404()->run();
        }

        $validator = new formValidator();
        $validator->add('required', 'name', '���������� ���� ������������� �����');
        $validator->add('required', 'title', '���������� ������� �����');
        $validator->add('regex', 'name', '������������ ������� � ��������������', '/^[a-z�-�0-9_\.\-! ]+$/i');
        $validator->add('callback', 'name', '������������� ������ ���� �������� � �������� ��������', array('checkPageFolderName', $path, $folderMapper, $isEdit));


        if ($validator->validate()) {
            $name = $this->request->get('name', 'string', SC_POST);
            $title = $this->request->get('title', 'string', SC_POST);

            if ($isEdit) {
                $folder = $targetFolder;
                $targetFolder = null;
            } else {
                $folder = $folderMapper->create();
            }

            $folder->setName($name);
            $folder->setTitle($title);

            $folderMapper->save($folder, $targetFolder);
            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->addParam('name', $path);
        $url->setAction($action);

        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('isEdit', $isEdit);

        $targetFolder = $isEdit ? $targetFolder : $folderMapper->create();
        $this->smarty->assign('folder', $targetFolder);
        return $this->smarty->fetch('page/saveFolder.tpl');
    }
}

function checkPageFolderName($name, $path, $mapper, $isEdit)
{
    if ($isEdit) {
        $path = explode('/', $path);
        $current = array_pop($path);

        return $current == $name || is_null($mapper->searchByPath(implode('/', $path) . '/' . $name));
    } else {
        return is_null($mapper->searchByPath($path . '/' . $name));
    }
}
?>