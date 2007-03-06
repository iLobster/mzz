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

fileLoader::load('page/forms/pageMoveForm');

/**
 * pageMoveController: контроллер для метода move модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1.1
 */

class pageMoveController extends simpleController
{
    public function getView()
    {
        if (($name = $this->request->get('name', 'string', SC_PATH)) == false) {
            if (($name = $this->request->get('id', 'string', SC_PATH)) == false) {
                $name = 'main';
            }
        }
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');
        $page = $pageFolderMapper->searchChild($name);

        $pageMapper = $this->toolkit->getMapper('page', 'page');

        if (!$page) {
            $this->request->setParam('name', '404');
            fileLoader::load('page/controllers/pageViewController');
            $controller = new pageViewController();
            return $controller->run();
        }

        $folders = $pageFolderMapper->searchAll();

        $form = pageMoveForm::getForm($page, $folders);

        if ($form->validate()) {
            $values = $form->exportValues();

            $destFolder = $pageFolderMapper->searchOneByField('id', $values['dest']);

            if (!$destFolder) {
                return $pageFolderMapper->get404()->run();
            }

            $page->setFolder($destFolder);
            $pageMapper->save($page);

            return jipTools::redirect();
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('page', $page);
        return $this->smarty->fetch('page/move.tpl');
    }
}

?>