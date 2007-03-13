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

fileLoader::load('comments/forms/commentsPostForm');

/**
 * commentsFolderPostController: контроллер для метода post модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1.1
 */

class commentsFolderPostController extends simpleController
{
    public function getView()
    {
        $parent_id = $this->request->get('id', 'integer', SC_PATH);

        $user = $this->toolkit->getUser();

        $form = commentsPostForm::getForm($this->request->get('id', 'integer', SC_PATH));

        $access = $this->request->get('access', 'boolean', SC_PATH);

        if (!is_null($access) && !$access) {
            return $user->getId() == MZZ_USER_GUEST_ID ? $this->smarty->fetch('comments/onlyAuth.tpl') : $this->smarty->fetch('comments/deny.tpl');
        }

        if ($form->validate() == false) {
            $section = $this->request->getSection();
            $session = $this->toolkit->getSession();
            $sess_name = $section . '_' . 'comments_' . $parent_id;

            if (strtolower($this->request->getMethod()) != 'post') {
                if ($session->exists($sess_name)) {
                    $form = unserialize($session->get($sess_name));
                    $session->destroy($sess_name);
                }

                $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
                $form->accept($renderer);
                $this->smarty->assign('action', 'post');
                $this->smarty->assign('form', $renderer->toArray());

                return $this->smarty->fetch('comments/post.tpl');
            }

            $values = $form->exportValues();
            $session->set($sess_name, serialize($form));
        } else {
            $commentsMapper = $this->toolkit->getMapper('comments', 'comments', 'comments');
            $commentsFolderMapper = $this->toolkit->getMapper('comments', 'commentsFolder', 'comments');

            $commentsFolder = $commentsFolderMapper->searchOneByField('parent_id', $parent_id);

            if ($commentsFolder) {

                $values = $form->exportValues();

                $comment = $commentsMapper->create();
                $comment->setText($values['text']);

                $user = $this->toolkit->getUser();

                $comment->setAuthor($user);
                $comment->setFolder($commentsFolder);

                $commentsMapper->save($comment);

            }
        }

        $this->response->redirect($values['url']);
    }
}

?>