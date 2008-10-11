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
 * pageSaveController: контроллер для метода save модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class pageSaveController extends simpleController
{
    protected function getView()
    {
        $pageMapper = $this->toolkit->getMapper('page', 'page');
        $name = $this->request->getString('name');
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
            $validator->add('required', 'name', 'Обязательное для заполнения поле');
            $validator->add('regex', 'name', 'Недопустимые символы в идентификаторе', '/^[a-z0-9_\.\-! ]+$/i');
            $validator->add('callback', 'name', 'Идентификатор должен быть уникален в пределах каталога', array('checkPageName', $page, $pageFolder));

            if ($validator->validate()) {
                $name = $this->request->getString('name', SC_POST);
                $title = $this->request->getString('title', SC_POST);
                $contentArea = $this->request->getString('contentArea', SC_POST);
                $compiled = $this->request->getBoolean('compiled', SC_POST);
                $allow_comment = $this->request->getBoolean('allow_comment', SC_POST);
                $keywords = $this->request->getString('keywords', SC_POST);
                $description = $this->request->getString('description', SC_POST);
                $descriptionReset = $this->request->getBoolean('descriptionReset', SC_POST);
                $keywordsReset = $this->request->getBoolean('keywordsReset', SC_POST);

                $page->setKeywords($keywords);
                $page->setKeywordsReset($keywordsReset);
                $page->setDescription($description);
                $page->setDescriptionReset($descriptionReset);

                $page->setName($name);
                $page->setTitle($title);
                $page->setContent($contentArea);
                $page->setCompiled($compiled);
                $page->setAllowComment($allow_comment);

                $page->setFolder($pageFolder);
                $pageMapper->save($page);
                return jipTools::redirect();
            }

            $url = new url('withAnyParam');
            $url->add('name', $pageFolder->getPath() . ($isEdit ? '/' . $page->getName() : ''));
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

function checkPageName($name, $page, $pageFolder)
{
    if ($name == $page->getName()) {
        return true;
    }
    $pageMapper = systemToolkit::getInstance()->getMapper('page', 'page');

    $criteria = new criteria();
    $criteria->add('folder_id', $pageFolder->getId())->add('name', $name);
    return is_null($pageMapper->searchOneByCriteria($criteria));
}
?>