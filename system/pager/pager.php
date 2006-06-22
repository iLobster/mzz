<?php

class pager
{
    private $baseurl;
    private $page;
    private $perPage;
    private $itemsCount;
    private $roundItems;
    private $pagesTotal;

    public function __construct($baseurl, $page, $perPage, $itemsCount = 0, $roundItems = 2)
    {
        $this->baseurl = $baseurl;
        $this->page = (int)$page;
        $this->perPage = (int)$perPage;
        $this->itemsCount = (int)$itemsCount;
        $this->roundItems = (int)$roundItems;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setCount($count)
    {
        $this->itemsCount = (int)$count;
    }

    public function getPagesTotal()
    {
        return ceil($this->itemsCount / $this->perPage);
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

        $this->pagesTotal = $this->getPagesTotal();
        $left = (($tmp = $this->page - $this->roundItems) > 1) ? $tmp : 1;
        $right = (($tmp = $this->page + $this->roundItems) < $this->pagesTotal) ? $tmp : $this->pagesTotal;

        for ($i = $left; $i <= $right; $i++) {
            $result[$i] = array('page' => $i, 'url' => $url . $i);
        }

        if ($this->page + $this->roundItems + 1 < $this->pagesTotal) {
            $result[] = array('skip' => true);
        }

        $result[$this->pagesTotal] = array('page' => $this->pagesTotal, 'url' => $url . $this->pagesTotal);

        if ($this->page > $this->pagesTotal) {
            $this->page = $this->pagesTotal;
        } elseif ($this->page < 1) {
            $this->page = 1;
        }

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