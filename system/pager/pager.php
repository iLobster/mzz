<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * pager: класс генерации списка страниц для постраничного вывода информации
 *
 * @package system
 * @version 0.1
 */

class pager
{
    /**
     * базовый урл, к которому добавляется переменная page с соответствующим номером страницы
     *
     * @var string
     */
    private $baseurl;

    /**
     * номер текущей страницы
     *
     * @var integer
     */
    private $page;

    /**
     * число объектов на страницу
     *
     * @var integer
     */
    private $perPage;

    /**
     * общее число объектов
     *
     * @var integer
     */
    private $itemsCount;

    /**
     * число номеров страниц, которые будут выводиться возле текущего
     * в случае, если между текущей и первой (или последней) страницей слишком много страниц
     * выглядит это примерно так:
     * 1 ... 2 <b>3</b> 4 ... 20
     * (текущая страница выделена жирным)
     * в данном случае $roundItems = 1
     *
     * @var integer
     */
    private $roundItems;

    /**
     * рассчитанное значение общего числа страниц
     *
     * @var integer
     */
    private $pagesTotal;

    /**
     * переменная для хранения сгенерированного результата
     * для предотвращения ненужной повторной обработки
     *
     * @var array
     */
    private $result;

    /**
     * конструктор
     *
     * @param базовый урл $baseurl
     * @param номер текущей страницы $page
     * @param число объектов на одну страницу $perPage
     * @param общее число объектов $itemsCount
     * @param число номеров страниц возле текущей $roundItems
     */
    public function __construct($baseurl, $page, $perPage, $itemsCount = 0, $roundItems = 2)
    {
        $this->baseurl = $baseurl;
        $this->page = (int)$page;
        $this->setPerPage($perPage);;
        $this->itemsCount = (int)$itemsCount;
        $this->roundItems = (int)$roundItems;
    }

    /**
     * метод установки числа объектов на 1 страницу
     *
     * @param integer $value
     */
    private function setPerPage($value)
    {
        if ($value < 1) {
            $value = 10;
        }

        $this->perPage = (int)$value;
    }

    /**
     * метод получения числа объектов на 1 страницу
     *
     * @return integer
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * метод получения номера текущей страницы
     *
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * метод получения общего числа объектов
     *
     * @return integer
     */
    public function getItemsCount()
    {
        return $this->itemsCount;
    }

    /**
     * метод установки общего числа объектов
     *
     * @param integer $count
     */
    public function setCount($count)
    {
        $this->itemsCount = (int)$count;
    }

    /**
     * метод получения чила страниц
     *
     * @return integer
     */
    public function getPagesTotal()
    {
        if (empty($this->pagesTotal)) {
            $this->pagesTotal = ceil($this->itemsCount / $this->getPerPage());
        }
        return $this->pagesTotal;
    }

    /**
     * метод получения части запроса, обеспечивающей выборку нужного числа объектов с нужным смещением
     *
     * @return string
     */
    public function getLimitQuery()
    {
        return ' LIMIT ' . ($this->page - 1) * $this->perPage . ', ' . $this->perPage;
    }

    /**
     * метод получения сгенерированного "пейджинга" в массив
     * во избежание повторного проведения аналогичных вычислений результаты кешируются в памяти
     *
     * @return array
     */
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
        return $this->result;
    }

    /**
     * метод получения отформатированного "пейджинга"
     * для форматирования используется smarty и специальный шаблон
     *
     * @return string
     */
    public function toString()
    {
        $toolkit = systemToolkit::getInstance();
        $smarty = clone $toolkit->getSmarty();
        $smarty->assign('pager', $this->toArray());
        return $smarty->fetch('pager.tpl');
    }
}

?>