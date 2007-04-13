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

//fileLoader::load('news/forms/newsSaveForm');
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
    public function getView()
    {
        $user = $this->toolkit->getUser();
        $newsMapper = $this->toolkit->getMapper('news', 'news');
        $id = $this->request->get('id', 'integer', SC_PATH);
        $newsFolder = null;

        if (empty($id)) {
            $path = $this->request->get('name', 'string', SC_PATH);
            $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');
            $newsFolder = $newsFolderMapper->searchByPath($path);
        }

        $news = $newsMapper->searchById($id);
        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        if (!empty($news) || (!$isEdit && isset($newsFolder) && !is_null($newsFolder))) {
            //$form = newsSaveForm::getForm($news, $this->request->getSection(), $action, $newsFolder, $isEdit);
            $validator = new formValidator();
            $validator->add('required', 'title','Необходимо назвать новость');

            if (!$validator->validate()) {
                $url = new url('withAnyParam');
                $url->setSection($this->request->getSection());
                $url->setAction($action);
                $url->addParam('name', $isEdit ? $news->getId() : $newsFolder->getPath());
                $this->smarty->assign('action', $url->get());
                $this->smarty->assign('errors', $validator->getErrors());

                //$renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
                //$renderer->setRequiredTemplate('{if $error}<font color="red"><strong>{$label}</strong></font>{else}{if $required}<span style="color: red;">*</span> {/if}{$label}{/if}');
                //$renderer->setErrorTemplate('{if $error}<div class="formErrorElement">{$html}</div><font color="gray" size="1">{$error}</font>{else}{$html}{/if}');
                //$form->accept($renderer);

                //$this->smarty->assign('form', $renderer->toArray());
                $this->smarty->assign('news', $news);
                $this->smarty->assign('isEdit', $isEdit);

                $title = $isEdit ? 'Редактирование -> ' . $news->getTitle() : 'Создание';
                $this->response->setTitle('Новости -> ' . $title);

                return $this->smarty->fetch('news/save.tpl');
            } else {
                //$values = $form->exportValues();
                $title = $this->request->get('title', 'string', SC_POST);
                $annotation = $this->request->get('annotation', 'string', SC_POST);
                $text = $this->request->get('text', 'string', SC_POST);

                $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');
                $folder = $newsFolderMapper->searchByPath($this->request->get('name', 'string', SC_PATH));

                if (!$isEdit) {
                    $news = $newsMapper->create();
                    $news->setFolder($folder->getId());
                    /*$date = explode(' ', $values['created']);
                    $time = explode(':', $date[0]);
                    $date = explode('/', $date[1]);
                    $created = mktime($time[0], $time[1], $time[2], $date[1], $date[0], $date[2]);
                    $news->setCreated($created);*/
                }

                $news->setTitle($title);
                $news->setEditor($user);
                $news->setText($text);
                $news->setAnnotation($annotation);
                $newsMapper->save($news);

                return jipTools::redirect();
            }
        }

        return $newsMapper->get404()->run();
    }
}

?>