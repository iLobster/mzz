<?php

class newsListController extends simpleController
{
    protected function getView()
    {
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');
        $path = $this->request->getString('name');
        $newsFolder = $newsFolderMapper->searchByPath($path);

        if (empty($newsFolder)) {
            return $this->forward404($newsFolderMapper);
        }

        $config = $this->toolkit->getConfig('news');
        $this->setPager($newsFolderMapper, $config->get('items_per_page'), true);

        $this->smarty->assign('news', $newsFolderMapper->getItems($newsFolder));
        $this->smarty->assign('folderPath', $newsFolder->getTreePath());
        $this->smarty->assign('rootFolder', $newsFolderMapper->searchByPath('root'));
        $this->smarty->assign('newsFolder', $newsFolder);

        return $this->smarty->fetch('news/list.tpl');
    }
}

?>