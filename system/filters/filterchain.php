<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * filterChain: ���������� ������� ������������ ��� ��������
 * 
 * @package system
 * @version 0.1
 */

class filterChain
{
    /**
     * ������ � ���������
     *
     * @access private
     * @var array
     */
    private $filters = array();
    
    /**
     * ������� �������
     *
     * @access private
     * @var int
     */
    private $counter = -1;
    
    /**
     * ������, ���������� ����������, ��������� ������� � �������
     *
     * @access private
     * @var object
     */
    private $response;

    /**
     * ����������� ������
     *
     * @access public
     * @param object $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    
    /**
     * ����������� ������ �������
     *
     * @access public
     * @param object $filter ������ ��� ���������� � �������
     */
    public function registerFilter($filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * ������� � ���������� ������� � �������
     *
     * @access public
     */
    public function next()
    {
        $this->counter++;
        
        if(isset($this->filters[$this->counter])) {
            $this->filters[$this->counter]->run($this, $this->response);
        }
    }

    /**
     * ������ ������� �������� �� ����������
     *
     * @access public
     */
    public function process()
    {
        $this->next();
    }
}

?>