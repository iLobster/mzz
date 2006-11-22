<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * newsCreateController: контроллер для метода create модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

fileLoader::load('news/views/newsCreateFolderForm');
fileLoader::load('news/views/newsCreateFolderView');

class newsCreateFolderController extends simpleController
{
    public function getView()
    {
        $user = $this->toolkit->getUser();

        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder', $this->request->getSection());

        $path = $this->request->get('name', 'string', SC_PATH);

        $targetFolder = $newsFolderMapper->searchByPath($path);

        $action = $this->request->getAction();

        if (!is_null($targetFolder)) {

            $form = newsCreateFolderForm::getForm($path, $newsFolderMapper, $action, $targetFolder);

            if ($form->validate() == false) {
                $view = new newsCreateFolderView($targetFolder, $form);
            } else {
                $values = $form->exportValues();

                if ($action == 'createFolder') {
                    // создаём папку
                    $folder = $newsFolderMapper->create();

                    $newsFolderMapper->createSubfolder($folder, $targetFolder);

                    $path .= '/';
                } else {
                    // изменяем папку
                    $folder = $newsFolderMapper->searchByPath($path);

                    // ищем все каталоги, которые лежат ниже изменяемого
                    $criterion = new criterion('path', $path . '%', criteria::LIKE);
                    $criterion->addAnd(new criterion('path', $path, criteria::NOT_EQUAL));
                    $criteria = new criteria();
                    $criteria->add($criterion);
                    $folders = $newsFolderMapper->searchAllByCriteria($criteria);

                    $pos = strrpos('/' . $path, '/');
                    if ($pos) {
                        $path = substr($path, 0, $pos - 1);
                        $path .= '/';
                    } else {
                        $path = '';
                    }

                    // для нижележащих каталогов меняем значение поля `path` на новое
                    foreach ($folders as $currentFolder) {
                        $currentFolder->setPath(str_replace($folder->getPath(), $path . $values['name'], $currentFolder->getPath()));
                        $newsFolderMapper->save($currentFolder);
                    }
                }

                $folder->setName($values['name']);

                $folder->setPath($path . $values['name']);

                $newsFolderMapper->save($folder);

                $view = new simpleJipRefreshView();
            }
        } else {
            fileLoader::load('news/views/news404View');
            $view = new news404View();
        }

        return $view;
    }
}

?>