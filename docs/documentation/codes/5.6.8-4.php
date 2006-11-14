<?php

fileLoader::load('comments/views/commentsFolderPostView');
fileLoader::load('comments/views/commentsPostForm');

class commentsFolderPostController extends simpleController
{
    public function getView()
    {
        $form = commentsPostForm::getForm($this->request->get('parent_id', 'integer', SC_PATH));

        return new commentsFolderPostView($form);
    }
}

?>