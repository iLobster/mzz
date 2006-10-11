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
     * ������������ ������
     *
     * @var array
     */
    private $aliases;

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
     * @param string $alias (optional)����� ���������� � ��
     */
    public function registerFilter(iFilter $filter, $alias = 'default')
    {
        $this->filters[] = $filter;
        $this->aliases[] = $alias;

    }

    /**
     * ������� � ���������� ������� � �������
     *
     */
    public function next()
    {
        $this->counter++;

        if (isset($this->filters[$this->counter])) {
            $this->filters[$this->counter]->run($this, $this->response, $this->request, $this->aliases[$this->counter]);
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