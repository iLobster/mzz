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
 * forumThreadController: контроллер для метода thread модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumThreadController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer');

        $threadMapper = $this->toolkit->getMapper('forum', 'thread');
        $postsMapper = $this->toolkit->getMapper('forum', 'post');

        $thread = $threadMapper->searchByKey($id);

        $config = $this->toolkit->getConfig('forum');
        $this->setPager($postsMapper, $config->get('posts_per_page'));

        $posts = $postsMapper->searchAllByField('thread_id', $id);

        $forumMapper = $thread->getForum()->getMapper();
        $forumMapper->storeView($thread);

        $this->smarty->assign('posts', $posts);
        $this->smarty->assign('thread', $thread);
        return $this->smarty->fetch('forum/thread.tpl');
    }
}

?>