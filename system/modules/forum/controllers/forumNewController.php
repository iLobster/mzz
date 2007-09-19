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
 * forumNewController: контроллер для метода new модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumNewController extends simpleController
{
    public function getView()
    {
        $forumMapper = $this->toolkit->getMapper('forum', 'forum');
        $threadMapper = $this->toolkit->getMapper('forum', 'thread');

        $new_threads = $forumMapper->getNewThreads();
        $criteria = new criteria();
        $criteria->setOrderByFieldDesc('post_date');
        $criteria->add('id', array_keys($new_threads), criteria::IN);

        $this->setPager($threadMapper);

        $threads = $threadMapper->searchAllByCriteria($criteria);

        $this->smarty->assign('threads', $threads);
        return $this->smarty->fetch('forum/new.tpl');
    }
}

?>