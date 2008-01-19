<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * pager: класс генерации списка страниц для постраничного вывода информации
 *
 * @package modules
 * @subpackage pager
 * @version 0.2.2
 */
class pager
{
    /**
     * базовый URL, к которому добавляется переменная page с соответствующим номером страницы
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
     * Флаг, изменяющий порядок страниц на противоположный (от больших к меньшим)
     *
     * @var boolean
     */
    private $reverse;

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
     * @param string $baseurl базовый урл
     * @param integer $page номер текущей страницы
     * @param integer $perPage число объектов на одну страницу
     * @param integer $roundItems число номеров страниц возле текущей
     * @param boolean $reverse обратный порядок страниц
     */
    public function __construct($baseurl, $page, $perPage, $roundItems = 2, $reverse = false)
    {
        $baseurl = preg_replace('/([&?])page=.*?($|&)/i', '$1', $baseurl);

        if (($end = strrpos($baseurl, '&') || ($end = strrpos($baseurl, '?'))) && $end === strlen($baseurl) - 1) {
            $baseurl = substr($baseurl, 0, -1);
        }

        $this->baseurl = $baseurl . (strpos($baseurl, '?') ? '&' : '?') . 'page=';
        $this->page = (int)$page;
        $this->setPerPage($perPage);
        $this->itemsCount = 0;
        $this->roundItems = (int)$roundItems;
        $this->reverse = $reverse;
    }

    /**
     * метод установки числа объектов на 1 страницу
     *
     * @param integer $value
     */
    private function setPerPage($value)
    {
        $this->perPage = ($value < 1) ? 10 : (int)$value;
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
     * Получение фактического номера страницы
     *
     * @return integer
     */
    public function getRealPage()
    {
        return $this->reverse ? $this->getPagesTotal() - $this->page + 1 : $this->page;
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
     * Метод получения ссылки на следующую страницу
     *
     * @return string|null ссылка на предыдущую страницу либо null, в случае если текущая страница последняя
     */
    public function getNext()
    {
        if ($this->reverse && $this->page > 1) {
            $page = $this->page - 1;
        } elseif (!$this->reverse && $this->page < $this->getPagesTotal()) {
            $page = $this->page + 1;
        }

        return isset($page) ? $this->baseurl . $page : null;
    }

    /**
     * Метод получения ссылки на предыдущую страницу
     *
     * @return string|null ссылка на предыдущую страницу либо null, в случае если текущая страница первая
     */
    public function getPrev()
    {
        if ($this->reverse && $this->page < $this->getPagesTotal()) {
            $page = $this->page + 1;
        } elseif (!$this->reverse && $this->page > 1) {
            $page = $this->page - 1;
        }

        return isset($page) ? $this->baseurl . $page : null;
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

        if ($this->page <= 0) {
            $this->page = $this->reverse ? $this->getPagesTotal() : 1;
        } elseif ($this->page > $this->getPagesTotal()) {
            $this->page = $this->getPagesTotal();
        }
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
     * @return object
     */
    public function getLimitQuery()
    {
        $criteria = new criteria();

        if ($this->page > 0) {
            $firstPage = $this->reverse ? $this->getPagesTotal() : 1;
            $offset = abs($this->page - $firstPage) * $this->perPage;
        } else {
            $offset = 0;
        }

        return $criteria->setLimit($this->perPage)->setOffset($offset);
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
            $sign = $this->reverse ? -1 : 1;

            $result = array();

            $pagesTotal = $this->getPagesTotal();

            if ($this->itemsCount > 0) {
                $firstPage = $this->reverse ? $pagesTotal : 1;
                $result[$firstPage] = array('page' => $firstPage, 'url' => $this->baseurl . $firstPage);

                $leftSkip = ($this->reverse ? $pagesTotal - $this->page - 1 : $this->page - 2) > $this->roundItems;
                $rightSkip = ($this->reverse ? $this->page - 2 : $pagesTotal - $this->page - 1) > $this->roundItems;

                if ($leftSkip) {
                    $result[] = array('skip' => true);
                    $left = $this->page - $sign * $this->roundItems;
                } else {
                    $left = $firstPage + $sign;
                }

                if ($rightSkip) {
                    $right = $this->page + $sign * $this->roundItems;
                } else {
                    $right = $this->reverse ? 1 : $pagesTotal;
                }


                while ($sign * ($right - $left) >= 0) {
                    $result[$left] = array('page' => $left, 'url' => $this->baseurl . $left);
                    $left += $sign;
                }

                if ($rightSkip) {
                    $result[] = array('skip' => true);
                    $lastPage = abs($firstPage - $pagesTotal) + 1;
                    $result[$lastPage] = array('page' => $lastPage, 'url' => $this->baseurl . $lastPage);
                }

                if (isset($result[$this->page])) {
                    $result[$this->page]['current'] = true;
                }
            }

            $this->result = $result;
        }
        return $this->result;
    }

    /**
     * метод получения отформатированного "пейджинга"
     * для форматирования используется smarty и специальный шаблон
     *
     * @param string $tpl имя шаблона отображения страниц
     * @return string
     */
    public function toString($tpl = 'pager/pager.tpl')
    {
        $toolkit = systemToolkit::getInstance();
        $smarty = $toolkit->getSmarty();
        $smarty->assign('pages', $this->toArray());
        return $smarty->fetch($tpl);
    }
}

?>