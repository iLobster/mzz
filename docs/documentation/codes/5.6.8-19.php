<?php

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
            $view = new commentsFolderPostView($form);
        } else {
            $values = $form->exportValues();

            $comment->setText($values['text']);
            $commentsMapper->save($comment);

            $view = new simpleJipCloseView();
        }

        return $view;
    }
}

?>