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
        $parent_id = $this->request->get('obj_id', 'integer', SC_PATH);
        var_dump($parent_id);
        $commentsFolder = $commentsFolderMapper->searchOneByField('parent_id', $parent_id);

        //$commentsFolderMapper->remove($commentsFolder->getId());

        return new simpleView();
    }
}

?>