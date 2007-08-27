<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * forumEditForumController: контроллер для метода editForum модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumEditForumController extends simpleController
{
    public function getView()
    {
        return $this->smarty->fetch('forum/editForum.tpl');
    }
}

?>