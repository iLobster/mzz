<?php

class pager
{
    private $baseurl;
    private $page;
    private $perPage;
    private $itemsCount;
    private $roundItems;
    private $pagesTotal;
    private $result;

    public function __construct($baseurl, $page, $perPage, $itemsCount = 0, $roundItems = 2)
    {
        $this->baseurl = $baseurl;
        $this->page = (int)$page;
        $this->setPerPage($perPage);;
        $this->itemsCount = (int)$itemsCount;
        $this->roundItems = (int)$roundItems;
    }

    private function setPerPage($value)
    {
        if ($value < 1) {
            $value = 10;
        }

        $this->perPage = (int)$value;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getItemsCount()
    {
        return $this->itemsCount;
    }

    public function setCount($count)
    {
        $this->itemsCount = (int)$count;
    }

    public function getPagesTotal()
    {
        if (empty($this->pagesTotal)) {
            $this->pagesTotal = ceil($this->itemsCount / $this->getPerPage());
        }
        return $this->pagesTotal;
    }

    public function toArray()
    {
        if (empty($this->result)) {

            $result = array();

            $url = $this->baseurl . (strpos($this->baseurl, '?') ? '&' : '?') . 'page=';

            if ($this->itemsCount > 0) {
                $result[1] = array('page' => 1, 'url' => $url . '1');
            }

            if ($this->page - $this->roundItems > 2) {
                $result[] = array('skip' => true);
            }

            $pagesTotal = $this->getPagesTotal();
            $left = (($tmp = $this->page - $this->roundItems) > 1) ? $tmp : 1;
            $right = (($tmp = $this->page + $this->roundItems) < $pagesTotal) ? $tmp : $pagesTotal;

            for ($i = $left; $i <= $right; $i++) {
                $result[$i] = array('page' => $i, 'url' => $url . $i);
            }

            if ($this->page + $this->roundItems + 1 < $pagesTotal) {
                $result[] = array('skip' => true);
            }

            $result[$pagesTotal] = array('page' => $pagesTotal, 'url' => $url . $pagesTotal);

            if ($this->page > $pagesTotal) {
                $this->page = $pagesTotal;
            } elseif ($this->page < 1) {
                $this->page = 1;
            }

            $result[$this->page]['current'] = true;

            $this->result = $result;
        }
        return $result;
    }

    public function toString()
    {
        $toolkit = systemToolkit::getInstance();
        $smarty = clone $toolkit->getSmarty();
        $smarty->assign('pager', $this->toArray());
        return $smarty->fetch('pager.tpl');
    }
}

?>