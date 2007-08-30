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

fileLoader::load('forms/validators/formValidator');

/**
 * forumMoveThreadController: ���������� ��� ������ moveThread ������ forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumMoveThreadController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer');

        $threadMapper = $this->toolkit->getMapper('forum', 'thread');
        $categoryMapper = $this->toolkit->getMapper('forum', 'category');

        $thread = $threadMapper->searchByKey($id);
        $categories = $categoryMapper->searchAll();

        $validator = new formValidator();
        $validator->add('callback', 'forum', '���������� ������� ������ �� ����������, ���� ������� � ��� �� ������', array('checkForumExists', $thread));

        if ($validator->validate()) {
            $oldForum = $thread->getForum();
            $forumMapper = $oldForum->getMapper();

            $forum = $forumMapper->searchByKey($this->request->get('forum', 'integer', SC_POST));
            $thread->setForum($forum);
            $threadMapper->save($thread);

            $oldForum->setThreadsCount($oldForum->getThreadsCount() - 1);
            $oldForum->setPostsCount($oldForum->getPostsCount() - $thread->getPostsCount());
            // ���� � ����������� ����� ��� ��������� ����
            if ($oldForum->getLastPost()->getThread()->getId() == $thread->getId()) {
                $criteria = new criteria();
                $criteria->addJoin($forum->section() . '_post', new criterion('p.thread_id', 'thread.id', criteria::EQUAL, true), 'p', criteria::JOIN_INNER);
                $criteria->add('forum_id', $oldForum->getId());
                $criteria->setOrderByFieldDesc('p.post_date');
                $criteria->setLimit(1);
                $last_thread = $threadMapper->searchOneByCriteria($criteria);

                $oldForum->setLastPost($last_thread->getLastPost());
            }
            $forumMapper->save($oldForum);


            $forum->setThreadsCount($forum->getThreadsCount() + 1);
            $forum->setPostsCount($forum->getPostsCount() + $thread->getPostsCount());
            if ($forum->getLastPost()->getPostDate() < $thread->getLastPost()->getPostDate()) {
                $forum->setLastPost($thread->getLastPost());
            }
            $forumMapper->save($forum);

            $url = new url('withId');
            $url->setAction('thread');
            $url->add('id', $id);

            $response = $this->toolkit->getResponse();
            $response->redirect($url->get());

            return;
        }

        $options = array();
        foreach ($categories as $category) {
            $options['category_' . $category->getId()] = array('content' => $category->getTitle());
            $tmp = array();
            foreach ($category->getForums() as $forum) {
                $tmp[$forum->getId()] = array('content' => $forum->getTitle());
            }
            $options['category_' . $category->getId()]['items'] = $tmp;
        }

        $options['category_' . $thread->getForum()->getCategory()->getId()]['items'][$thread->getForum()->getId()]['disabled'] = 'disabled';

        $url = new url('withId');
        $url->add('id', $id);
        $url->setAction('moveThread');

        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('categories', $options);
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('thread', $thread);
        return $this->smarty->fetch('forum/moveThread.tpl');
    }
}

function checkForumExists($id, $thread)
{
    $forumMapper = $thread->getForum()->getMapper();
    $forum = $forumMapper->searchByKey($id);
    return $forum && $forum->getId() != $thread->getForum()->getId();
}

?>