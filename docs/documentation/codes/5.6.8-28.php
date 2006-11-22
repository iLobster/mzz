<?php

class commentsFolderDeleteFolderController extends simpleController
{
    public function getView()
    {
        $commentsFolderMapper = $this->toolkit->getMapper('comments', 'commentsFolder', 'comments');
        $commentsMapper = $this->toolkit->getMapper('comments', 'comments', 'comments');

        $criteria = new criteria();
        $criteria->addJoin('sys_access_registry', new criterion('r.obj_id', 'commentsfolder.parent_id', criteria::EQUAL, true), 'r');
        $criteria->add('r.obj_id', null, criteria::IS_NULL);
        $commentsFolders = $commentsFolderMapper->searchAllByCriteria($criteria);

        foreach ($commentsFolders as $val) {
            $commentsFolderMapper->remove($val->getId());
        }

        return '';
    }
}

?> 