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
        $id = $this->request->getInteger('id');

        $postMapper = $this->toolkit->getMapper('forum', 'post');
        $user = $this->toolkit->getUser();
        $forumMapper = $this->toolkit->getMapper('forum', 'forum');
        $time = max($forumMapper->retrieveView($id), $user->getLastLogin());

        /* SELECT COUNT(*) AS `cnt`, MAX(`id`) AS `max_id` FROM `forum_post` WHERE `forum_post`.`thread_id` = :thread_id AND `forum_post`.`post_date` < :last_login */
        $criteria = new criteria($postMapper->getTable());
        $criteria->addSelectField(new sqlFunction('count', '*', true), 'cnt');
        $criteria->addSelectField(new sqlFunction('max', 'id', true), 'max_id');
        $criteria->add('thread_id', $id);
        $criteria->add('post_date', $time, criteria::LESS_EQUAL);

        $select = new simpleSelect($criteria);

        $db = db::factory();
        $cnt = $db->getRow($select->toString());

        /* SELECT `id` FROM `forum_post` WHERE `forum_post`.`id` > :post_id AND `forum_post`.`thread_id` = :thread_id ORDER BY `forum_post`.`id` ASC LIMIT 1 */
        $criteria = new criteria($postMapper->getTable());
        $criteria->addSelectField('id');
        $criteria->add('id', $cnt['max_id'], criteria::GREATER);
        $criteria->add('thread_id', $id);
        $criteria->setOrderByFieldAsc('id');
        $criteria->setLimit(1);

        $select = new simpleSelect($criteria);
        $last_post = $db->getRow($select->toString());

        if (!$last_post) {
            $last_post['id'] = $cnt['max_id'];
        } else {
            $cnt['cnt']++;
        }

        $config = $this->toolkit->getConfig('forum');
        $per_page = $config->get('posts_per_page');

        $page = ceil($cnt['cnt'] / $per_page);

        $url = new url('withId');
        $url->setAction('thread');
        $url->add('id', $id);
        if ($page > 1) {
            $url->add('page', $page, true);
        }

        $response = $this->toolkit->getResponse();
        $response->redirect($url->get() . '#post_' . $last_post['id']);
    }
}

?>