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
 * forumSaveThreadController: контроллер для метода saveThread модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumSaveThreadController extends simpleController
{
    public function getView()
    {
        $action = $this->request->getAction();
        $isEdit = ($action == 'editThread');

        $threadMapper = $this->toolkit->getMapper('forum', 'thread');

        $id = $this->request->get('id', 'integer');

        if ($isEdit) {
            $thread = $threadMapper->searchByKey($id);
        } else {
            $forumMapper = $this->toolkit->getMapper('forum', 'forum');
            $forum = $forumMapper->searchByKey($id);
            $thread = $threadMapper->create();
        }

        if (($isEdit && is_null($thread)) || (!$isEdit && is_null($forum))) {
            return $threadMapper->get404()->run();
        }

        $validator = new formValidator();
        $validator->add('required', 'title', 'Необходимо название треду');
        $validator->add('required', 'text', 'Необходимо написать сообщение');

        if ($validator->validate()) {
            $title = $this->request->get('title', 'string', SC_POST);
            $text = $this->request->get('text', 'string', SC_POST);
            $sticky = $this->request->get('sticky', 'boolean', SC_POST);

            $postMapper = $this->toolkit->getMapper('forum', 'post');

            if ($isEdit) {
                $closed = $this->request->get('closed', 'boolean', SC_POST);
                $thread->setIsClosed($this->request->get('closed', 'boolean', SC_POST));

                $post = $thread->getFirstPost();
                $post->setText($text);
                $postMapper->save($post);
            } else {
                $thread->setAuthor($me = $this->toolkit->getUser());
                $thread->setForum($forum);

                $post = $postMapper->create();
                $post->setText($text);
                $post->setAuthor($me);
                $post->setThread($thread);

                $postMapper->save($post);

                $thread->setLastPost($post);
                $thread->setFirstPost($post);
                $threadMapper->save($thread);

                $forum = $thread->getForum();
                $forum->setLastPost($post);
                $forumMapper->save($forum);
            }

            $thread->setIsSticky($sticky);
            $thread->setTitle($title);
            $threadMapper->save($thread);

            $url = new url('withId');
            $url->setAction('goto');
            $url->add('id', $post->getId());

            $response = $this->toolkit->getResponse();
            $response->redirect($url->get());
        }

        $url = new url('withId');
        $url->setAction($action);
        $url->add('id', $id);

        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('thread', $thread);

        if (!$isEdit) {
            $this->smarty->assign('forum', $forum);
        }

        return $this->smarty->fetch('forum/saveThread.tpl');
    }
}

?>