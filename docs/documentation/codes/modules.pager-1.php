<?php

class simpleController
{
    [...]

    /**
     * Метод установки пейджера для получаемой коллекции объектов
     *
     * @param mapper $item маппер, который возвращает требуемую коллекцию объектов
     * @param integer $per_page число объектов на странице
     * @param boolean $reverse флаг, изменяющий порядок страниц на противоположный (от больших к меньшим)
     * @param integer $round_items число выводимых номеров страниц рядом с текущим (Например: ... 4 5 6 _7_ 8 9 10 ... -> $roundItems = 3)
     * @return pager
     */
    public function setPager(mapper $mapper, $per_page = 20, $reverse = false, $round_items = 2)
    {
        fileLoader::load('modules/pager/plugins/pagerPlugin');
        $pager = new pager($this->request->getRequestUrl(), $this->request->getInteger('page', SC_REQUEST), $per_page, $round_items, $reverse);
        $mapper->attach(new pagerPlugin($pager));

        $this->smarty->assign('pager', $pager);

        return $pager;
    }
}

?>