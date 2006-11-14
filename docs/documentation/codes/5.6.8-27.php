<?php

fileLoader::load('comments/views/commentsFolderPostView');
fileLoader::load('comments/views/commentsPostForm');
fileLoader::load('comments/views/commentsPostSuccessView');

class commentsFolderPostController extends simpleController
{
    public function getView()
    {
        $form = commentsPostForm::getForm($this->request->get('parent_id', 'integer', SC_PATH));

        if ($form->validate() == false) {
            $view = new commentsFolderPostView($form);
        } else {
            $parent_id = $this->request->get('id', 'integer', SC_PATH);

            $commentsMapper = $this->toolkit->getMapper('comments', 'comments', 'comments');
            $commentsFolderMapper = $this->toolkit->getMapper('comments', 'commentsFolder', 'comments');

            $commentsFolder = $commentsFolderMapper->searchOneByField('parent_id', $parent_id);

            $values = $form->exportValues();

            $comment = $commentsMapper->create();
            $comment->setText($values['text']);

            $user = $this->toolkit->getUser();

            $comment->setAuthor($user);
            $comment->setFolder($commentsFolder);

            $commentsMapper->save($comment);

            $view = new commentsPostSuccessView($values['url']);
        }

        return $view;
    }
}

?> 