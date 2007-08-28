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
 * forumGotoController: контроллер для метода goto модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumGotoController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer');

        $postMapper = $this->toolkit->getMapper('forum', 'post');
        $post = $postMapper->searchByKey($id);

        $criteria = new criteria($postMapper->getTable());
        $criteria->addSelectField(new sqlFunction('count', '*', true), 'cnt');
        $criteria->add('thread_id', $post->getThread()->getId());
        $criteria->add('id', $id, criteria::LESS_EQUAL);

        $select = new simpleSelect($criteria);

        $db = db::factory();
        $cnt = $db->getRow($select->toString());

        // в конфиг закинуть число постов и тредов на странице
        $per_page = 5;

        $page = ceil($cnt['cnt'] / $per_page);

        $url = new url('withId');
        $url->setAction('thread');
        $url->add('id', $post->getThread()->getId());
        if ($page > 1) {
            $url->add('page', $page, true);
        }

        $response = $this->toolkit->getResponse();
        $response->redirect($url->get() . '#post_' . $id);
    }
}

?>