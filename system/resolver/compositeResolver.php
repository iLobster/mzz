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
 * compositeResolver: ���������� �������� composite ��� ����������
 * �������� ������ ����������, ������� �� ������� �������� ��������� ����������
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

class compositeResolver
{
    /**
     * ������ ��� �������� ����������
     *
     * @access private
     * @var array
     */
    private $resolvers = array();
    
    /**
     * ����� ��� ���������� ����������
     *
     * @param object $resolver
     */
    public function addResolver($resolver)
    {
        $this->resolvers[] = $resolver;
    }
    
    /**
     * ������ �������, ������ ��������� ����������
     * ������������ �� ��� ���, ���� ���� �� ���������� �� ������ ������ � �����������
     *
     * @param string $request ������
     * @return string|null ���� � �����, ���� ������ ��������� ����� �� ����������, ���� null
     */
    public function resolve($request)
    {
        foreach ($this->resolvers as $resolver) {
            if (null !== ($filename = $resolver->resolve($request))) {
                return $filename;
            }
        }
        return null;
    }
}

?>