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
 * decoratingResolver: ���������� �������� decorator ��� ����������
 * �� ���� ����������� ��� ������������ ���������
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

abstract class decoratingResolver
{
    /**
     * ��������, ������� ����� ��������������
     *
     * @access protected
     * @var object
     */
    protected $resolver = null;
    
    /**
     * �����������
     *
     * @access public
     * @param object $resolver ��������, ������� ����� ��������������
     */
    public function __construct($resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * �������� ����� resolve ��� ������������� ���������
     * � ����������� ����� ����� ����������� �������������
     *
     * @param string $request ������
     * @return string|null ���� �� ����� ���� ������, ���� null � ��������� ������
     */
    public function resolve($request)
    {
       return $this->resolver->resolve($request);
    }

    /**
     * �������� ��� ������ ������������� ���������
     *
     * @param string $callname ��� ������
     * @param array $args ���������
     * @return mixed ���������� ���������� ����������� ������
     */
    public function __call($callname, $args)
    {
        if (method_exists($this->resolver, $callname)) {
            return call_user_func_array(array($this->resolver, $callname), $args);
        } else {
            echo "Exception 'method not found'";
        }
    }
}

?>