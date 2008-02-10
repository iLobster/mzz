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
        $threads_per_page = 5;
        $posts_per_page = 5;

        $forumMapper = $this->toolkit->getMapper('forum', 'forum');
        $id = $this->request->getInteger('id');

        $forum = $forumMapper->searchByKey($id);

        $criteria = new criteria();
        $criteria->add('forum_id', $id)->add('sticky', 0);
        $criteria->setOrderByFieldDesc('last_post.id');

        $threadMapper = $this->toolkit->getMapper('forum', 'thread');

        $this->setPager($threadMapper, $threads_per_page);

        $threads = $threadMapper->searchAllByCriteria($criteria);

        $stickys = array();
        if ($this->request->getInteger('page', SC_GET) < 2) {
            $criteria = new criteria();
            $criteria->add('forum_id', $id)->add('sticky', 1);
            $criteria->setOrderByFieldDesc('last_post.id');

            $stickys = $threadMapper->searchAllByCriteria($criteria);
        }

        $pagers = array();
        $url = new url('withId');
        $url->setAction('thread');
        foreach ($threads as $thread) {
            if ($thread->getPostsCount() > $posts_per_page) {
                $url->add('id', $thread->getId());
                $pagers[$thread->getId()] = new pager($url->get(), 0, $posts_per_page);
                $pagers[$thread->getId()]->setCount($thread->getPostsCount() + 1);
            }
        }

        $this->smarty->assign('pagers', $pagers);
        $this->smarty->assign('threads', $threads);
        $this->smarty->assign('stickys', $stickys);
        $this->smarty->assign('forum', $forum);
        return $this->smarty->fetch('forum/list.tpl');
    }
}

?>