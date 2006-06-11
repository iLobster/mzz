<?php

class pager
{
    private $baseurl;
    private $page;
    private $perPage;
    private $itemsCount;
    private $roundItems;

    public function __construct($baseurl, $page, $perPage, $itemsCount, $roundItems = 2)
    {
        $this->baseurl = $baseurl;
        $this->page = $page;
        $this->perPage = $perPage;
        $this->itemsCount = $itemsCount;
        $this->roundItems = $roundItems;
    }

    public function toArray()
    {
        $result = array();

        $url = $this->baseurl . (strpos($this->baseurl, '?') ? '&' : '?') . 'page=';

        if ($this->itemsCount > 0) {
            $result[1] = array('page' => 1, 'url' => $url . '1');
        }

        if ($this->page - $this->roundItems > 2) {
            $result[] = array('skip' => true);
        }

        $pagesTotal = ceil($this->itemsCount / $this->perPage);
        $left = (($tmp = $this->page - $this->roundItems) > 1) ? $tmp : 1;
        $right = (($tmp = $this->page + $this->roundItems) < $pagesTotal) ? $tmp : $pagesTotal;

        for ($i = $left; $i <= $right; $i++) {
            $result[$i] = array('page' => $i, 'url' => $url . $i);
        }

        if ($this->page + $this->roundItems + 1 < $pagesTotal) {
            $result[] = array('skip' => true);
        }

        $result[$pagesTotal] = array('page' => $pagesTotal, 'url' => $url . $pagesTotal);
        
        $result[$this->page]['current'] = true;

        return $result;
    }

    public function toString()
    {
        $toolkit = systemToolkit::getInstance();
        $smarty = $toolkit->getSmarty();
        $smarty->assign('pager', $this->toArray());
        $str = $smarty->fetch('pager.tpl');
        return $str;
    }
}

?>