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
 * forumListController: контроллер для метода list модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumListController extends simpleController
{
    public function getView()
    {
        $forumMapper = $this->toolkit->getMapper('forum', 'forum');
        $id = $this->request->get('id', 'integer');

        $forum = $forumMapper->searchByKey($id);

        $criteria = new criteria();
        $criteria->add('forum_id', $id);
        $criteria->setOrderByFieldDesc('last_post.id');

        $threadMapper = $this->toolkit->getMapper('forum', 'thread');

        $this->setPager($threadMapper, 5);

        $threads = $threadMapper->searchAllByCriteria($criteria);

        $this->smarty->assign('threads', $threads);
        $this->smarty->assign('forum', $forum);
        return $this->smarty->fetch('forum/list.tpl');
    }
}

?>