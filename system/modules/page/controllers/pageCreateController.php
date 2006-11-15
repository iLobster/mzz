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
 * pageCreateController: контроллер для метода create модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

fileLoader::load('page/views/pageCreateView');
fileLoader::load('page/views/pageCreateSuccessView');
fileLoader::load('page/views/pageCreateForm');
fileLoader::load("page/mappers/pageMapper");

class pageCreateController extends simpleController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getView()
    {
        $pageMapper = $this->toolkit->getMapper('page', 'page', $this->request->getSection());
        //$pageMapper = new pageMapper($this->request->getSection());
        $page = $pageMapper->create();

        $form = pageCreateForm::getForm();
        if ($form->validate() == false) {
            $view = new pageCreateView($page, $form);
        } else {
            $values = $this->request->exportFormValues($form);
            $page->setName($values['name']);
            $page->setTitle($values['title']);
            $page->setContent($values['content']);
            $pageMapper->save($page);
            $view = new pageCreateSuccessView($page, $form);
        }
        return $view;
    }
}

?>
