<?php

class commentsFolderListView extends simpleView
{
    public function toString()
    {
        $this->smarty->assign('parent_id', $this->DAO->getParentId());
        $this->smarty->assign('comments', $this->DAO->getComments());
        return $this->smarty->fetch('comments.list.tpl');
    }
}

?>