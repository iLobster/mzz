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

fileLoader::load('page/views/pageCreateFolderForm');

/**
 * pageCreateFolderController: контроллер для метода createFolder модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */
class pageCreateFolderController extends simpleController
{
    public function getView()
    {
        $user = $this->toolkit->getUser();

        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');

        $path = $this->request->get('name', 'string', SC_PATH);

        $targetFolder = $pageFolderMapper->searchByPath($path);

        $action = $this->request->getAction();

        if (!is_null($targetFolder)) {

            $form = pageCreateFolderForm::getForm($path, $pageFolderMapper, $action, $targetFolder);

            if ($form->validate() == false) {
                $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
                $form->accept($renderer);

                $this->smarty->assign('form', $renderer->toArray());

                $this->response->setTitle('Страницы -> Создание папки');
                $view = $this->smarty->fetch('page/createFolder.tpl');
            } else {
                $values = $form->exportValues();

                if ($action == 'createFolder') {
                    // создаём папку
                    $folder = $pageFolderMapper->create();

                    $pageFolderMapper->createSubfolder($folder, $targetFolder);

                    $path .= '/';
                } else {
                    // изменяем папку
                    $folder = $pageFolderMapper->searchByPath($path);

                    // ищем все каталоги, которые лежат ниже изменяемого
                    $criterion = new criterion('path', $path . '%', criteria::LIKE);
                    $criterion->addAnd(new criterion('path', $path, criteria::NOT_EQUAL));
                    $criteria = new criteria();
                    $criteria->add($criterion);
                    $folders = $pageFolderMapper->searchAllByCriteria($criteria);

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
                        $pageFolderMapper->save($currentFolder);
                    }
                }

                $folder->setName($values['name']);
                $folder->setTitle($values['title']);

                $folder->setPath($path . $values['name']);

                $pageFolderMapper->save($folder);

                $view = new simpleJipRefreshView();
            }
        } else {
            fileLoader::load('page/views/page404View');
            $view = new page404View();
        }

        return $view;
    }
}

?>