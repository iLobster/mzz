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

/**
 * commentsFolderListController: контроллер для метода list модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1.1
 */

class commentsFolderListController extends simpleController
{
    protected function getView()
    {
        $commentsFolderMapper = $this->toolkit->getMapper('comments', 'commentsFolder', 'comments');

        $parent_id = $this->request->getInteger('id');

        $commentsFolder = $commentsFolderMapper->searchOneByField('parent_id', $parent_id);

        $this->smarty->assign('parent_id', $commentsFolder->getParentId());
        $this->smarty->assign('comments', $commentsFolder->getComments());
        $this->smarty->assign('folder', $commentsFolder);
        return $this->smarty->fetch('comments/list.tpl');
    }
}

?>