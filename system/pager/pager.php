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
 * @version 0.1
 */
class pager
{
    /**
     * ������� ���, � �������� ����������� ���������� page � ��������������� ������� ��������
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
     */
    public function __construct($baseurl, $page, $perPage, $roundItems = 2)
    {
        $this->baseurl = $baseurl;
        $this->page = ($page > 0) ? (int)$page : 1;
        $this->setPerPage($perPage);;
        $this->itemsCount = 0;
        $this->roundItems = (int)$roundItems;
    }

    /**
     * ����� ��������� ����� �������� �� 1 ��������
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
        return $criteria->setLimit($this->perPage)->setOffset(($this->page - 1) * $this->perPage);
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
     * ����� ��������� ������������������ "���������"
     * ��� �������������� ������������ smarty � ����������� ������
     *
     * @return string
     */
    public function toString()
    {
        $toolkit = systemToolkit::getInstance();
        $smarty = $toolkit->getSmarty();
        $smarty->assign('pages', $this->toArray());
        return $smarty->fetch('pager.tpl');
    }
}

?>