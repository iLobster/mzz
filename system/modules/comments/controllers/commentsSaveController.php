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
 * commentsSaveController: контроллер для метода post модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1.2
 */

class commentsSaveController extends simpleController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();
        $access = $this->request->getBoolean('access');

        if (!is_null($access) && !$access) {
            return $user->getId() == MZZ_USER_GUEST_ID ? $this->smarty->fetch('comments/onlyAuth.tpl') : $this->smarty->fetch('comments/deny.tpl');
        }

        $commentsFolderMapper = $this->toolkit->getMapper('comments', 'commentsFolder');
        $commentsMapper = $this->toolkit->getMapper('comments', 'comments');
        $id = $this->request->getRaw('id');

        if ($id instanceof commentsFolder) {
            $commentsFolder = $id;
            $id = $commentsFolder->getId();
        }

        $action = $this->request->getAction();
        $isEdit = $action == 'edit';
        $isReply = false;

        if ($isEdit) {
            $comment = $commentsMapper->searchById($id);
            if (!$comment) {
                return $this->forward404($commentsMapper);
            }

            $commentsFolder = $comment->getFolder();

        } else {
            if (!isset($commentsFolder)) {

                $commentsFolder = $commentsFolderMapper->searchById($id);
                if (!$commentsFolder) {
                    return $this->forward404($commentsFolderMapper);
                }
            }

            $comment = $commentsMapper->create();

            $replyTo = $this->request->getInteger('replyTo', SC_PATH | SC_POST | SC_GET);
            $isReply = ($replyTo > 0);
        }

        $validator = new formValidator();
        $validator->add('required', 'text', 'Введите комментарий');

        $backUrl = $this->request->getString('backUrl', SC_POST);

        if ($validator->validate()) {
            $text = $this->request->getString('text', SC_POST);

            if (!$isEdit) {
                $comment->setFolder($commentsFolder);
                $comment->setUser($user);

                if ($isReply) {
                    $answerComment = $commentsMapper->searchById($replyTo);

                    if ($answerComment) {
                        $comment->setTreeParent($answerComment);
                    } else {
                        return $this->forward404($commentsMapper);
                    }
                }
            }

            $comment->setText($text);
            $commentsMapper->save($comment);

            if ($isEdit) {
                return jipTools::redirect();
            } else {
                $this->response->redirect($backUrl);
                return;
            }
        }

        $url = new url('withId');
        $url->setAction($action);
        $url->add('id', ($isEdit) ? $comment->getId() : $commentsFolder->getId());

        $this->smarty->assign('comment', $comment);
        $this->smarty->assign('commentsFolder', $commentsFolder);
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('isReply', $isReply);
        if ($isReply) {
            $this->smarty->assign('replyTo', $replyTo);
        }
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('user', $user);

        if (!$backUrl) {
            $backUrl = $this->request->getServer('REQUEST_URI');
        }

        $this->smarty->assign('backUrl', $backUrl);

        return $this->smarty->fetch('comments/post.tpl');
    }
}
?>