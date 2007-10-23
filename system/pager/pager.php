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
 * pager: ����� ��������� ������ ������� ��� ������������� ������ ����������
 *
 * @package system
 * @subpackage pager
 * @version 0.2.2
 */
class pager
{
    /**
     * ������� URL, � �������� ����������� ���������� page � ��������������� ������� ��������
     *
     * @var string
     */
    private $baseurl;

    /**
     * ����� ������� ��������
     *
     * @var integer
     */
    private $page;

    /**
     * ����� �������� �� ��������
     *
     * @var integer
     */
    private $perPage;

    /**
     * ����� ����� ��������
     *
     * @var integer
     */
    private $itemsCount;

    /**
     * ����� ������� �������, ������� ����� ���������� ����� ��������
     * � ������, ���� ����� ������� � ������ (��� ���������) ��������� ������� ����� �������
     * �������� ��� �������� ���:
     * 1 ... 2 <b>3</b> 4 ... 20
     * (������� �������� �������� ������)
     * � ������ ������ $roundItems = 1
     *
     * @var integer
     */
    private $roundItems;

    /**
     * ������������ �������� ������ ����� �������
     *
     * @var integer
     */
    private $pagesTotal;

    /**
     * ����, ���������� ������� ������� �� ��������������� (�� ������� � �������)
     *
     * @var boolean
     */
    private $reverse;

    /**
     * ���������� ��� �������� ���������������� ����������
     * ��� �������������� �������� ��������� ���������
     *
     * @var array
     */
    private $result;

    /**
     * �����������
     *
     * @param string $baseurl ������� ���
     * @param integer $page ����� ������� ��������
     * @param integer $perPage ����� �������� �� ���� ��������
     * @param integer $roundItems ����� ������� ������� ����� �������
     * @param boolean $reverse �������� ������� �������
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
     * ����� ��������� ����� �������� �� 1 ��������
     *
     * @param integer $value
     */
    private function setPerPage($value)
    {
        $this->perPage = ($value < 1) ? 10 : (int)$value;
    }

    /**
     * ����� ��������� ����� �������� �� 1 ��������
     *
     * @return integer
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * ��������� ������������ ������ ��������
     *
     * @return integer
     */
    public function getRealPage()
    {
        $page = $this->page > 0 ? $this->page : 1;
        return $this->reverse ? $this->getPagesTotal() - $page + 1 : $page;
    }

    /**
     * ����� ��������� ������ ������� ��������
     *
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * ����� ��������� ������ �� ��������� ��������
     *
     * @return string|null ������ �� ���������� �������� ���� null, � ������ ���� ������� �������� ���������
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
     * ����� ��������� ������ �� ���������� ��������
     *
     * @return string|null ������ �� ���������� �������� ���� null, � ������ ���� ������� �������� ������
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
     * ����� ��������� ������ ����� ��������
     *
     * @return integer
     */
    public function getItemsCount()
    {
        return $this->itemsCount;
    }

    /**
     * ����� ��������� ������ ����� ��������
     *
     * @param integer $count
     */
    public function setCount($count)
    {
        $this->itemsCount = (int)$count;

        if ($this->page > $this->getPagesTotal()) {
            $this->page = $this->getPagesTotal();
        }
    }

    /**
     * ����� ��������� ���� �������
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
     * ����� ��������� ����� �������, �������������� ������� ������� ����� �������� � ������ ���������
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
     * ����� ��������� ���������������� "���������" � ������
     * �� ��������� ���������� ���������� ����������� ���������� ���������� ���������� � ������
     *
     * @return array
     */
    public function toArray()
    {
        if (empty($this->result)) {
            $sign = $this->reverse ? -1 : 1;

            $result = array();

            $pagesTotal = $this->getPagesTotal();

            if ($this->page <= 0) {
                $this->page = $this->reverse ? $pagesTotal : 1;
            }

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
     * ����� ��������� ������������������ "���������"
     * ��� �������������� ������������ smarty � ����������� ������
     *
     * @param string $tpl ��� ������� ����������� �������
     * @return string
     */
    public function toString($tpl = 'pager.tpl')
    {
        $toolkit = systemToolkit::getInstance();
        $smarty = $toolkit->getSmarty();
        $smarty->assign('pages', $this->toArray());
        return $smarty->fetch($tpl);
    }
}

?>