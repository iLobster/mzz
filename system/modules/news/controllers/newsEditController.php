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

fileLoader::load('news/views/newsEditForm');

/**
 * NewsEditController: контроллер для метода edit модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */
class newsEditController extends simpleController
{
    public function getView()
    {
        $user = $this->toolkit->getUser();

        $newsMapper = $this->toolkit->getMapper('news', 'news');

        $id = $this->request->get('id', 'integer', SC_PATH);

        $newsFolder = null;

        if (is_null($id)) {
            $path = $this->request->get('name', 'string', SC_PATH);
            $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');
            $newsFolder = $newsFolderMapper->searchByPath($path);
        }

        $news = $newsMapper->searchById($id);

        $action = $this->request->getAction();
        if (!empty($news) || ($action == 'create' && isset($newsFolder) && !is_null($newsFolder))) {
            $form = newsEditForm::getForm($news, $this->request->getSection(), $action, $newsFolder);

            if ($form->validate() == false) {
                $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
                $form->accept($renderer);

                $this->smarty->assign('form', $renderer->toArray());
                $this->smarty->assign('news', $news);
                $this->smarty->assign('action', $action);

                $title = $action == 'edit' ? 'Редактирование -> ' . $news->getTitle() : 'Создание';
                $this->response->setTitle('Новости -> ' . $title);

                return $this->smarty->fetch('news/edit.tpl');
            } else {
                $values = $form->exportValues();
                $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder', $this->request->getSection());
                $folder = $newsFolderMapper->searchByPath($this->request->get('name', 'string', SC_PATH));

                if ($action == 'create') {
                    $news = $newsMapper->create();
                    $news->setFolder($folder->getId());
                }

                $news->setTitle($values['title']);
                $news->setEditor($user);
                $news->setText($values['text']);
                $news->setCreated($values['created']);
                $newsMapper->save($news);

                $view = new simpleJipRefreshView();
            }
            return $view;
        } else {
            fileLoader::load('news/views/news404View');
            return new news404View();
        }
    }
}

?>