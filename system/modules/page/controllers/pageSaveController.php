<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
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
 * pageSaveController: ���������� ��� ������ save ������ page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class pageSaveController extends simpleController
{
    public function getView()
    {




        $pageMapper = $this->toolkit->getMapper('page', 'page');
        $name = $this->request->get('name', 'string', SC_PATH);
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        if ($isEdit) {
            $page = $pageFolderMapper->searchChild($name);
            $pageFolder = $page->getFolder();
        } else {
            $page = $pageMapper->create();
            $pageFolder = $pageFolderMapper->searchByPath($name);
        }



        if (!empty($page) || (!$isEdit && isset($pageFolder) && !is_null($pageFolder))) {
            $validator = new formValidator();
            $validator->add('required', 'name', '������������ ��� ���������� ����');
            $validator->add('regex', 'name', '������������ ������� � ��������������', '/^[a-z�-�0-9_\.\-! ]+$/i');
            $validator->add('callback', 'name', '������������� ������ ���� �������� � �������� ��������', array('checkPageName', $page));

            if ($validator->validate()) {
                $name = $this->request->get('name', 'string', SC_POST);
                $title = $this->request->get('title', 'string', SC_POST);
                $contentArea = $this->request->get('contentArea', 'string', SC_POST);

                $page->setName($name);
                $page->setTitle($title);
                $page->setContent($contentArea);

                $page->setFolder($pageFolder);
                $pageMapper->save($page);
                return jipTools::redirect();
            }

            $url = new url('pageActions');
            $url->addParam('name', $pageFolder->getPath() . ($isEdit ? '/' . $page->getName() : ''));
            $url->setAction($action);

            $this->smarty->assign('form_action', $url->get());
            $this->smarty->assign('errors', $validator->getErrors());
            $this->smarty->assign('page', $page);
            $this->smarty->assign('isEdit', $isEdit);

            return $this->smarty->fetch('page/save.tpl');
        }

        return $pageMapper->get404()->run();
    }
}

function checkPageName($name, $page)
{
    if ($name == $page->getName()) {
        return true;
    }

    $criteria = new criteria();
    $criteria->add('folder_id', $page->getFolder()->getId())->add('name', $name);

    $pageMapper = systemToolkit::getInstance()->getMapper('page', 'page');
    return is_null($pageMapper->searchOneByCriteria($criteria));
}
?>