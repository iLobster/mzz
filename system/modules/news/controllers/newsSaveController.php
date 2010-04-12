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
 * newsSaveController: контроллер для метода save модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1.1
 */

class newsSaveController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');
        $path = $this->request->getString('name');

        $user = $this->toolkit->getUser();
        $newsMapper = $this->toolkit->getMapper('news', 'news');
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');
        $folder = $newsFolderMapper->searchByPath($path);

        $this->acceptLang($newsMapper);

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');
        $news = ($isEdit) ? $newsMapper->searchByKey($id) : $newsMapper->create();

        if (empty($news) || (!$isEdit && empty($folder))) {
            return $this->forward404($newsMapper);
        }

        $validator = new formValidator();
        $validator->rule('required', 'title', i18n::getMessage('error_title_required', 'news'));

        if (!$isEdit) {
            $validator->rule('required', 'created', i18n::getMessage('error_created_required', 'news'));
            $validator->rule('regex', 'created', i18n::getMessage('error_created_format', 'news'), '#^(([0-1]\d|[2][0-3])\:[0-5]\d\:[0-5]\d\s([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[2][0]\d{2})$#');
        }

        if ($validator->validate()) {
            $title = $this->request->getString('title', SC_POST);
            $annotation = $this->request->getString('annotation', SC_POST);
            $text = $this->request->getString('text', SC_POST);

            if (!$isEdit) {
                $created = $this->request->getString('created', SC_POST);
                $news->setFolder($folder->getId());
                $news->setCreated($created);
            }

            $news->setTitle($title);
            $news->setEditor($user);
            $news->setText($text);
            $news->setAnnotation($annotation);
            $newsMapper->save($news);

            return jipTools::redirect();
        }

        if ($isEdit) {
            $url = new url('withId');
            $url->add('id', $news->getId());
        } else {
            $url = new url('withAnyParam');
            $url->add('name', $folder->getTreePath());
        }
        $url->setAction($action);

        $this->view->assign('action', $url->get());
        $this->view->assign('validator', $validator);
        $this->view->assign('news', $news);
        $this->view->assign('isEdit', $isEdit);

        return $this->render('news/save.tpl');
    }
}

?>