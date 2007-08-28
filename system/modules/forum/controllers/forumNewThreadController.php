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
 * forumNewThreadController: контроллер для метода newThread модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumNewThreadController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer');

        $forumMapper = $this->toolkit->getMapper('forum', 'forum');
        $forum = $forumMapper->searchByKey($id);

        $validator = new formValidator();
        $validator->add('required', 'title', 'Необходимо название треду');
        $validator->add('required', 'text', 'Необходимо написать сообщение');

        if ($validator->validate()) {
            $title = $this->request->get('title', 'string', SC_POST);
            $text = $this->request->get('text', 'string', SC_POST);

            $threadMapper = $this->toolkit->getMapper('forum', 'thread');
            $postMapper = $this->toolkit->getMapper('forum', 'post');

            $thread = $threadMapper->create();
            $thread->setTitle($title);
            $thread->setAuthor($me = $this->toolkit->getUser());
            $thread->setForum($forum);

            $threadMapper->save($thread);

            $post = $postMapper->create();
            $post->setText($text);
            $post->setAuthor($me);
            $post->setThread($thread);

            $postMapper->save($post);

            $thread->setLastPost($post);
            $threadMapper->save($thread);

            $forum = $thread->getForum();
            $forum->setLastPost($post);
            $forumMapper->save($forum);

            $url = new url('withId');
            $url->setAction('thread');
            $url->add('id', $thread->getId());

            $response = $this->toolkit->getResponse();
            $response->redirect($url->get());
        }

        $url = new url('withId');
        $url->setAction('newThread');
        $url->add('id', $id);

        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('forum', $forum);
        return $this->smarty->fetch('forum/newThread.tpl');
    }
}

?>