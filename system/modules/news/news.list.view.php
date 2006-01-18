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
 * NewsListModel: вид дл€ метода list модул€ news
 *
 * @package news
 * @version 0.1
 */

class newsListView extends simpleView
{
    public function toString()
    {
        // в будущем список новостей будет получатьс€ из newsFolderTableModule

        //$newsFolders = new newsFolderTableModule();
       // $folder = $newsFolders->searchByName($path_from_url);
       // $data = $concreteFolder->getItems();

        //$data = $this->tableModule->searchByFolder(1);
        $this->smarty->assign('news', $this->tableModule);
        $this->smarty->assign('title', 'Ќовости -> —писок');
        return $this->smarty->fetch('news.list.tpl');
    }
}

?>