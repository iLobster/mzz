<?php

class commentsFolderListController extends simpleController
{
    public function getView()
    {
        $commentsFolderMapper = $this->toolkit->getMapper('comments', 'commentsFolder', 'comments');

        $parent_id = $this->request->get('parent_id', 'integer', SC_PATH);

        $commentsFolder = $commentsFolderMapper->searchOneByField('parent_id', $parent_id);

        return new commentsFolderListView($commentsFolder);
    }
}

?>