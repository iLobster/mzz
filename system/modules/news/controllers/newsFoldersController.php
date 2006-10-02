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
 * NewsViewController: контроллер для метода list модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

fileLoader::load('news/views/newsFolders.view');
fileLoader::load("news/mappers/newsFolderMapper");

class newsFoldersController extends simpleController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getView()
    {
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder', $this->request->getSection());

        $folders = $newsFolderMapper->getFolders('');
        return new newsFoldersView($folders);
    }
}

?>