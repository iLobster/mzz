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
 * @version 0.1.1
 */

class forumPostController extends simpleController
{
    public function getView()
    {
        $action = $this->request->getAction();
        $isEdit = $action == 'edit';

        $user = $this->toolkit->getUser();

        $id = $this->request->getInteger('id');
        $isQuickPost = $this->request->getBoolean('quickpost');

        $threadMapper = $this->toolkit->getMapper('forum', 'thread');
        $postMapper = $this->toolkit->getMapper('forum', 'post');
        $profileMapper = $this->toolkit->getMapper('forum', 'profile');

        $profile = $profileMapper->searchByUser($user);

        if ($isEdit) {
            $post = $postMapper->searchByKey($id);
            $thread = $post->getThread();
        } else {
            $thread = $threadMapper->searchByKey($id);
            $post = $postMapper->create();
        }

        $access = $this->request->getBoolean('access', SC_PATH);

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
            $text = $this->request->getString('text', SC_POST);

            if (!$isEdit) {
                $time = strtotime('tomorrow');
                if ($thread->getLastPost()->getAuthor()->getId() == $user->getId() && $thread->getPostsCount()) {
                    $time = time() - (($thread->getLastPost()->getPostDate() - $thread->getFirstPost()->getPostDate()) / $thread->getPostsCount());
                }
                // проверяем - что предыдущий пост был того же автора и время между последним постом и текущим - меньше среднего времени между постами
                // в этом случае - добавляем текущее сообщение к предыдущему
                if ($thread->getLastPost()->getPostDate() >= $time) {
                    $post = $thread->getLastPost();
                    $post->setEditDate(new sqlFunction('UNIX_TIMESTAMP'));
                    $isEdit = true;
                    $this->smarty->assign('post', $post);
                    $this->smarty->assign('text', $text);
                    $text = $this->smarty->fetch('forum/append.tpl');
                } else {
                    $post = $postMapper->create();
                    $post->setAuthor($profile);
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

        if (!$isQuickPost) {
            $config = $this->toolkit->getConfig('forum');
            $criteria = new criteria;
            $criteria->add('thread_id', $thread->getId())->setOrderByFieldDesc('id')->setLimit($config->get('posts_per_page'));

            $posts = $postMapper->searchAllByCriteria($criteria);
            $this->smarty->assign('posts', $posts);
        }

        $this->smarty->assign('post', $post);
        $this->smarty->assign('thread', $thread);
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('action', $url->get());

        return $this->smarty->fetch($isQuickPost ? 'forum/quickpost.tpl' : 'forum/post.tpl');
    }
}

?>