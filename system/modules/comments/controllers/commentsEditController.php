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
 * commentsEditController: контроллер для метода edit модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */

fileLoader::load('comments/views/commentsFolderPostView');
fileLoader::load('comments/views/commentsPostForm');

class commentsEditController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);
        $commentsMapper = $this->toolkit->getMapper('comments', 'comments', 'comments');

        $comment = $commentsMapper->searchById($id);

        $form = commentsPostForm::getForm($id, 'edit', $comment);

        if ($form->validate() == false) {
            $view = new commentsFolderPostView($form, 'edit');
        } else {
            $values = $form->exportValues();

            $comment->setText($values['text']);
            $commentsMapper->save($comment);

            $view = new simpleJipRefreshView();
        }

        return $view;
    }
}

?>