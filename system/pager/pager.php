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
 * @version 0.2
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
        $this->baseurl = $baseurl;
        $this->page = $page;
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
     * ����� ��������� ������ ������� ��������
     *
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
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

        if ($this->page) {
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

            if (!$this->page) {
                $this->page = $this->reverse ? $pagesTotal : 1;
            }

            $url = $this->baseurl . (strpos($this->baseurl, '?') ? '&' : '?') . 'page=';

            if ($this->itemsCount > 0) {
                $firstPage = $this->reverse ? $pagesTotal : 1;
                $result[$firstPage] = array('page' => $firstPage, 'url' => $url . $firstPage);

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
                    $result[$left] = array('page' => $left, 'url' => $url . $left);
                    $left += $sign;
                }

                if ($rightSkip) {
                    $result[] = array('skip' => true);
                    $lastPage = abs($firstPage - $pagesTotal) + 1;
                    $result[$lastPage] = array('page' => $lastPage, 'url' => $url . $lastPage);
                }

                $result[$this->page]['current'] = true;
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