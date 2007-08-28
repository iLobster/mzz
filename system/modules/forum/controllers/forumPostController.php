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
 * forumPostController: контроллер для метода post модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumPostController extends simpleController
{
    public function getView()
    {
        $action = $this->request->getAction();
        $isEdit = $action == 'edit';

        $id = $this->request->get('id', 'integer');

        $threadMapper = $this->toolkit->getMapper('forum', 'thread');
        $postMapper = $this->toolkit->getMapper('forum', 'post');
        if ($isEdit) {
            $post = $postMapper->searchByKey($id);
            $thread = $post->getThread();
        } else {
            $thread = $threadMapper->searchByKey($id);
            $post = $postMapper->create();
        }

        $validator = new formValidator();

        $validator->add('required', 'text', 'Необходимо написать сообщение');

        if ($validator->validate()) {
            $text = $this->request->get('text', 'string', SC_POST);

            if (!$isEdit) {
                $post = $postMapper->create();
                $post->setAuthor($this->toolkit->getUser());
                $post->setThread($thread);
            }

            $post->setText($text);
            $postMapper->save($post);

            if (!$isEdit) {
                $thread->setLastPost($post);
                $threadMapper->save($thread);
            }

            $forum = $thread->getForum();
            $forum->setLastPost($post);
            $forum->getMapper()->save($forum);

            $url = new url('withId');
            $url->setAction('thread');
            $url->add('id', $thread->getId());

            $response = $this->toolkit->getResponse();
            $response->redirect($url->get());
        }

        $url = new url('withId');
        $url->setAction($action);
        $url->add('id', $id);

        $this->smarty->assign('post', $post);
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('action', $url->get());
        return $this->smarty->fetch('forum/post.tpl');
    }
}

?>