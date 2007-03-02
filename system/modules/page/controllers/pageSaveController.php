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

fileLoader::load('page/forms/pageSaveForm');

/**
 * pageSaveController: контроллер для метода save модуля page
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
        $page = $pageFolderMapper->searchChild($name);

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        if ($isEdit) {
            $pageFolder = $page->getFolder();
        } else {
            $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');
            $pageFolder = $pageFolderMapper->searchByPath($name);
        }

        if (!empty($page) || !$isEdit) {
            $form = pageSaveForm::getForm($page, $this->request->getSection(), $action, $pageFolder, $isEdit);

            if ($form->validate() == false) {
                $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
                $form->accept($renderer);

                $this->smarty->assign('form', $renderer->toArray());
                $this->smarty->assign('page', $page);
                $this->smarty->assign('isEdit', $isEdit);

                $title = $isEdit ? 'Редактирование -> ' . $page->getName() : 'Создание';
                $this->response->setTitle('Страницы -> ' . $title);
                $view = $this->smarty->fetch('page/save.tpl');
            } else {
                $values = $form->exportValues();
                if (!$isEdit) {
                    $page = $pageMapper->create();
                }
                $page->setName($values['name']);
                $page->setTitle($values['title']);
                $page->setContent($values['contentArea']);
                $page->setFolder($pageFolder);
                $pageMapper->save($page);
                $view = jipTools::redirect();
            }
            return $view;
        } else {
            return $pageMapper->get404()->run();
        }
    }
}

?>