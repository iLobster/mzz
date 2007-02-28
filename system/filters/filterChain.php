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
 * filterChain: ���������� ������� ������������ ��� ��������
 *
 * @package system
 * @subpackage filters
 * @version 0.1
 */

class filterChain
{
    /**
     * ������ � ���������
     *
     * @var array
     */
    private $filters = array();

    /**
     * ������� �������
     *
     * @var int
     */
    private $counter = -1;

    /**
     * ������, ���������� ����������, ��������� ������� � �������
     *
     * @var response
     */
    private $response;

    /**
     * Request
     *
     * @var object
     */
    private $request;

    /**
     * ����������� ������
     *
     * @param response $response
     * @param object $request
     */
    public function __construct($response, $request)
    {
        $this->response = $response;
        $this->request = $request;
    }


    /**
     * ����������� ������ �������
     *
     * @param object $filter ������ ��� ���������� � �������
     */
    public function registerFilter(iFilter $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * ������� � ���������� ������� � �������
     *
     */
    public function next()
    {
        $this->counter++;

        if (isset($this->filters[$this->counter])) {
            $this->filters[$this->counter]->run($this, $this->response, $this->request);
        }
    }

    /**
     * ������ ������� �������� �� ����������
     *
     */
    public function process()
    {
        $this->next();
    }
}

?>