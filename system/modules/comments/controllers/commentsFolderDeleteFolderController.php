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
 * commentsFolderDeleteFolderController: контроллер для метода deleteFolder модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */

class commentsFolderDeleteFolderController extends simpleController
{
    public function getView()
    {
        $commentsFolderMapper = $this->toolkit->getMapper('comments', 'commentsFolder', 'comments');
        $commentsMapper = $this->toolkit->getMapper('comments', 'comments', 'comments');

        $criteria = new criteria();
        $criteria->addJoin('sys_access_registry', new criterion('r.obj_id', 'commentsFolder.parent_id', criteria::EQUAL, true), 'r');
        $criteria->add('r.obj_id', null, criteria::IS_NULL);
        $commentsFolders = $commentsFolderMapper->searchAllByCriteria($criteria);

        foreach ($commentsFolders as $val) {
            $commentsFolderMapper->remove($val->getId());
        }

        return '';
    }
}

?>