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

/**
 * commentsFolderPostController: контроллер для метода post модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */

fileLoader::load('comments/views/commentsFolderPostView');
fileLoader::load('comments/views/commentsPostForm');
fileLoader::load('comments/views/commentsPostSuccessView');

class commentsFolderPostController extends simpleController
{
    public function getView()
    {
        $form = commentsPostForm::getForm($this->request->get('parent_id', 'integer', SC_PATH));

        $access = $this->request->get('access', 'boolean', SC_PATH);

        if (!is_null($access) && !$access) {
            fileLoader::load('comments/views/commentsOnlyAuthView');

            $user = $this->toolkit->getUser();
            return new commentsOnlyAuthView($user->getId() == MZZ_USER_GUEST_ID);
        }

        if ($form->validate() == false) {
            $view = new commentsFolderPostView($form);
        } else {
            $parent_id = $this->request->get('id', 'integer', SC_PATH);

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

            $view = new commentsPostSuccessView($values['url']);
        }

        return $view;
    }
}

?>