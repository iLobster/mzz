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

fileLoader::load('news/views/newsMoveForm');

/**
 * newsMoveController: контроллер для метода move модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class newsMoveController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);

        $newsMapper = $this->toolkit->getMapper('news', 'news');
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');

        $news = $newsMapper->searchById($id);

        if (!$news) {
            return $newsMapper->get404()->run();
        }

        $folders = $newsFolderMapper->searchAll();

        $form = newsMoveForm::getForm($news, $folders);

        if ($form->validate()) {
            $values = $form->exportValues();

            $destFolder = $newsFolderMapper->searchById($values['dest']);

            if (!$destFolder) {
                /* @todo get404() ? */
                return 'каталог назначения не найден';
            }

            $news->setFolder($destFolder);
            $newsMapper->save($news);

            return jipTools::redirect();
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('news', $news);
        return $this->smarty->fetch('news/move.tpl');
    }
}

?>