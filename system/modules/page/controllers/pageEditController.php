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
 * pageEditController: ���������� ��� ������ edit ������ page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

fileLoader::load('page/views/pageEditView');
fileLoader::load('page/views/pageEditSuccessView');
fileLoader::load('page/views/pageEditForm');
fileLoader::load("page/mappers/pageMapper");

class pageEditController extends simpleController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getView()
    {
        $pageMapper = $this->toolkit->getMapper('page', 'page', $this->request->getSection());

        if (($name = $this->request->get('name', 'string', SC_PATH)) == null) {
            $name = $this->request->get('name', 'string', SC_POST);
        }

        if (is_null($name)) {
            $name = $this->request->get('id', 'string', SC_PATH);
        }

        $page = $pageMapper->searchByName($name);

        if ($page) {
            $form = pageEditForm::getForm($page, $this->request->getSection());

            if ($form->validate() == false) {
                $view = new pageEditView($page, $form);
            } else {
                $values = $this->request->exportFormValues($form);
                $page->setName($values['name']);
                $page->setTitle($values['title']);
                $page->setContent($values['content']);
                $pageMapper->save($page);
                $view = new simpleJipRefreshView();
            }
            return $view;
        } else {
            fileLoader::load('page/views/page404View');
            return new page404View();
        }
    }
}

?>
