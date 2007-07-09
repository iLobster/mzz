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
 * newsMoveController: контроллер дл€ метода move модул€ news
 *
 * @package modules
 * @subpackage news
 * @version 0.2
 */

class newsMoveController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);
        $dest = $this->request->get('dest', 'integer', SC_POST);

        $newsMapper = $this->toolkit->getMapper('news', 'news');
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');
        $news = $newsMapper->searchById($id);

        if (!$news) {
            return $newsMapper->get404()->run();
        }

        $folders = $newsFolderMapper->searchAll();

        $validator = new formValidator();
        $validator->add('required', 'dest', 'ќб€зательное дл€ заполнени€ поле');
        $validator->add('callback', 'dest', ' аталог назначени€ не существует', array('checkDestNewsFolderExists'));

        if ($validator->validate()) {
            $destFolder = $newsFolderMapper->searchById($dest);

            if (!$destFolder) {
                return $newsFolderMapper->get404()->run();
            }

            $news->setFolder($destFolder);
            $newsMapper->save($news);

            return jipTools::redirect();
        }

        $url = new url('withId');
        $url->setAction('move');
        $url->addParam('id', $news->getId());

        $dests = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getPath();
        }

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('dests', $dests);
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('news', $news);
        return $this->smarty->fetch('news/move.tpl');
    }
}

function checkDestNewsFolderExists($dest)
{
    $folderMapper = systemToolkit::getInstance()->getMapper('news', 'newsFolder');
    $destFolder = $folderMapper->searchById($dest);
    return (bool)$destFolder;
}
?>