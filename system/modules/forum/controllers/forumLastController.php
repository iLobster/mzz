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
 * forumLastController: контроллер для метода last модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumLastController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer');

        $postMapper = $this->toolkit->getMapper('forum', 'post');
        $user = $this->toolkit->getUser();
        $forumMapper = $this->toolkit->getMapper('forum', 'forum');
        $time = max($forumMapper->retrieveView($id), $user->getLastLogin());

        $criteria = new criteria($postMapper->getTable());
        $criteria->addSelectField(new sqlFunction('count', '*', true), 'cnt');
        $criteria->addSelectField(new sqlFunction('max', 'id', true), 'max_id');
        $criteria->add('thread_id', $id);
        $criteria->add('post_date', $time, criteria::LESS);

        $select = new simpleSelect($criteria);

        $db = db::factory();
        $cnt = $db->getRow($select->toString());

        // в конфиг закинуть число постов и тредов на странице
        $per_page = 5;

        $page = ceil($cnt['cnt'] / $per_page);

        $url = new url('withId');
        $url->setAction('thread');
        $url->add('id', $id);
        if ($page > 1) {
            $url->add('page', $page, true);
        }

        $response = $this->toolkit->getResponse();
        $response->redirect($url->get() . '#post_' . $cnt['max_id']);
    }
}

?>