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
        $this->acceptLang($pageMapper);

        $name = $this->request->getString('name');
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        if ($isEdit) {
            $page = $pageFolderMapper->searchChild($name);
            if (empty($page)) {
                return $this->forward404($pageFolderMapper);
            }
            $pageFolder = $page->getFolder();
        } else {
            $page = $pageMapper->create();
            $pageFolder = $pageFolderMapper->searchByPath($name);
        }

        if (empty($page) || ($isEdit && empty($pageFolder))) {
            return $this->forward404($pageMapper);
        }


        $validator = new formValidator();
        $validator->rule('required', 'page[name]', i18n::getMessage('error_name_required', 'page'));
        $validator->rule('regex', 'page[name]', i18n::getMessage('error_name_invalid', 'page'), '/^[-_a-z0-9]+$/i');
        $validator->rule('callback', 'page[name]', i18n::getMessage('error_name_unique', 'page'), array(array($this, 'checkUniquePageName'), $page, $pageFolder));

        if ($validator->validate()) {
            $data = new arrayDataspace($this->request->getArray('page', SC_POST));

            $page->setKeywords($data['keywords']);
            $page->setDescription($data['description']);
            $page->setName($data['name']);
            $page->setTitle($data['title']);
            $page->setContent($data['content']);

            $page->setCompiled((int) $data['compiled']);
            $page->setAllowComment((int) $data['allow_comment']);
            $page->setDescriptionReset((int) $data['descriptionReset']);
            $page->setKeywordsReset((int) $data['keywordsReset']);

            $page->setFolder($pageFolder);
            $pageMapper->save($page);
            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->add('name', $pageFolder->getTreePath() . ($isEdit ? '/' . $page->getName() : ''));
        $url->setAction($action);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('page', $page);
        $this->smarty->assign('validator', $validator);
        $this->smarty->assign('isEdit', $isEdit);

        return $this->smarty->fetch('page/save.tpl');
    }

    public function checkUniquePageName($name, $page, $pageFolder)
    {
        if ($name == $page->getName()) {
            return true;
        }
        $pageMapper = $this->toolkit->getMapper('page', 'page');

        return is_null($pageMapper->searchByNameInFolder($name, $pageFolder->getId()));
    }
}
?>