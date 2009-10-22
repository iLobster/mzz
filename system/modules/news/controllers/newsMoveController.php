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

        $id = $this->request->getInteger('id');

        $news = $newsMapper->searchByKey($id);

        if (!$news) {
            return $this->forward404($newsMapper);
        }

        $validator = new formValidator();
        $validator->rule('required', 'dest', 'Необходимо указать каталог назначения');

        if ($validator->validate()) {
            $dest = $this->request->getInteger('dest', SC_POST);
            $destFolder = $newsFolderMapper->searchByKey($dest);

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
        foreach ($folders as $val) {
            $dests[$val->getId()] = str_repeat('&nbsp;', ($val->getTreeLevel() - 1) * 5) . $val->getTitle();
        }

        $url = new url('withId');
        $url->setAction('move');
        $url->add('id', $news->getId());

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('validator', $validator);

        $this->smarty->assign('news', $news);
        $this->smarty->assign('dests', $dests);
        return $this->smarty->fetch('news/move.tpl');
    }
}
?>