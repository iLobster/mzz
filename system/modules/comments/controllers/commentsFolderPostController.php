<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

fileLoader::load('forms/validators/formValidator');

/**
 * commentsFolderPostController: ���������� ��� ������ post ������ comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1.2
 */

class commentsFolderPostController extends simpleController
{
    public function getView()
    {
        $parent_id = $this->request->get('id', 'integer', SC_PATH);

        $user = $this->toolkit->getUser();

        $validator = new formValidator();
        $validator->add('required', 'text', '���������� ������ ���������');

        $access = $this->request->get('access', 'boolean', SC_PATH);

        if (!is_null($access) && !$access) {
            return $user->getId() == MZZ_USER_GUEST_ID ? $this->smarty->fetch('comments/onlyAuth.tpl') : $this->smarty->fetch('comments/deny.tpl');
        }

        $action = $this->request->getAction();
        $isEdit = $action == 'edit';

        if (!$validator->validate()) {
            $section = $this->request->getSection();
            $session = $this->toolkit->getSession();
            $sess_name = $section . '_' . 'comments_' . $parent_id;

            if (strtolower($this->request->getMethod()) != 'post') {

                $this->smarty->assign('text', '');
                $this->smarty->assign('errors', $validator->getErrors());

                if ($isEdit) {
                    $commentsMapper = $this->toolkit->getMapper('comments', 'comments', 'comments');
                    $comment = $commentsMapper->searchById($parent_id);
                    $this->smarty->assign('text', $comment->getText());
                }

                if ($session->exists($sess_name)) {
                    $arr = unserialize($session->get($sess_name));
                    $this->smarty->assign('text', $arr['text']);
                    $this->smarty->assign('errors', $arr['validator']->getErrors());
                    $session->destroy($sess_name);
                }

                $this->smarty->assign('action', $action);
                $this->smarty->assign('isEdit', $isEdit);

                $url = new url('withId');
                $url->setAction($action);
                $url->addParam('id', $parent_id);

                $this->smarty->assign('action', $url->get());
                $this->smarty->assign('url', $this->request->get('REQUEST_URI', 'string', SC_SERVER));

                return $this->smarty->fetch('comments/post.tpl');
            }

            $text = $this->request->get('text', 'string', SC_POST);
            $session->set($sess_name, serialize(array('text' => $text, 'validator' => $validator)));

        } else {
            $commentsMapper = $this->toolkit->getMapper('comments', 'comments', 'comments');
            $commentsFolderMapper = $this->toolkit->getMapper('comments', 'commentsFolder', 'comments');

            if ($isEdit) {
                $comment = $commentsMapper->searchById($parent_id);
            } else {
                $commentsFolder = $commentsFolderMapper->searchOneByField('parent_id', $parent_id);

                $comment = $commentsMapper->create();
                $comment->setFolder($commentsFolder);
                $user = $this->toolkit->getUser();
                $comment->setAuthor($user);
            }

            $text = $this->request->get('text', 'string', SC_POST);

            $comment->setText($text);

            $commentsMapper->save($comment);

            if ($isEdit) {
                return jipTools::redirect();
            }
        }

        $url = $this->request->get('url', 'string', SC_POST);
        $this->response->redirect($url);
    }
}

?>