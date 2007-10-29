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
 * newsMoveController: контроллер для метода move модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.2
 */

class newsMoveController extends simpleController
{
    protected function getView()
    {
        $newsMapper = $this->toolkit->getMapper('news', 'news');
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');

        $id = $this->request->get('id', 'integer', SC_PATH);

        $news = $newsMapper->searchById($id);

        if (!$news) {
            return $newsMapper->get404()->run();
        }

        $validator = new formValidator();
        $validator->add('required', 'dest', 'Необходимо указать каталог назначения');

        if ($validator->validate()) {
            $dest = $this->request->get('dest', 'integer', SC_POST);
            $destFolder = $newsFolderMapper->searchById($dest);

            if (!$destFolder) {
                $controller = new messageController('Каталог назначения не найден', messageController::WARNING);
                return $controller->run();
            }
            
            $news->setFolder($destFolder);
            $newsMapper->save($news);

            return jipTools::redirect();
        }

        $folders = $newsFolderMapper->searchAll();
        $dests = array();
        $styles = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = str_repeat('&nbsp;', ($val->getTreeLevel() - 1) * 5) . $val->getTitle();
        }

        $url = new url('withId');
        $url->setAction('move');
        $url->add('id', $news->getId());

        $this->smarty->assign('news', $news);
        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('dests', $dests);
        $this->smarty->assign('styles', $styles);
        return $this->smarty->fetch('news/move.tpl');
    }
}
?>