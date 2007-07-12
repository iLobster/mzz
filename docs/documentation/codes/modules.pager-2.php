<?php

class newsListController extends simpleController
{
    protected function getView()
    {
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');
        $path = $this->request->get('name', 'string', SC_PATH);
        $newsFolder = $newsFolderMapper->searchByPath($path);

        if (empty($newsFolder)) {
            return $newsFolderMapper->get404()->run();
        }

        $config = $this->toolkit->getConfig('news');
        $this->setPager($newsFolder, $config->get('items_per_page'), true);

        $this->smarty->assign('folderPath', $newsFolder->getPath());
        $this->smarty->assign('news', $newsFolder->getItems());
        $this->smarty->assign('newsFolder', $newsFolder);

        return $this->smarty->fetch('news/list.tpl');
    }
}

?>