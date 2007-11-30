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

        $user = $this->toolkit->getUser();

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

        $access = $this->request->get('access', 'boolean', SC_PATH);

        if (!is_null($access) && !$access) {
            if (!$user->isLoggedIn()) {
                return $this->smarty->fetch('forum/onlyAuth.tpl');
            } elseif ($thread->getIsClosed()) {
                return $this->smarty->fetch('forum/closed.tpl');
            }
            return $postMapper->get404()->run();
        }

        $validator = new formValidator();

        $validator->add('required', 'text', 'Необходимо написать сообщение');

        if ($validator->validate()) {
            $text = $this->request->get('text', 'string', SC_POST);

            if (!$isEdit) {
                // @todo: интервал в конфиг
                if ($thread->getLastPost()->getPostDate() >= strtotime('-15 minutes')) {
                    $post = $thread->getLastPost();
                    $post->setPostDate(new sqlFunction('UNIX_TIMESTAMP'));
                    $isEdit = true;
                    // @todo: сделать по-человечески
                    $text = $post->getText() . "\r\n\r\nдобавлено\r\n\r\n" . $text;
                } else {
                    $post = $postMapper->create();
                    $post->setAuthor($user);
                    $post->setThread($thread);
                }
            }

            $post->setText($text);
            $postMapper->save($post);

            if (!$isEdit) {
                $thread->setLastPost($post);
                $threadMapper->save($thread);

                $forum = $thread->getForum();
                $forum->setLastPost($post);
                $forum->getMapper()->save($forum);
            }

            $url = new url('withId');
            $url->setAction('goto');
            $url->add('id', $post->getId());

            $response = $this->toolkit->getResponse();
            $response->redirect($url->get());

            return;
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