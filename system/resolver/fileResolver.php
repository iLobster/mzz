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
 * fileResolver: ������� ��������, �� �������� ����������� ��� ���������
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

class fileResolver
{
    /**
     * ������ ��������� (�������� ��� ������, ��� ������) ��� ������
     *
     * @var array
     */
    private $patterns = array();
    
    /**
     * �����������
     *
     * @param string $pattern ������� ��� ������
     */
    public function __construct($pattern)
    {
        $this->addPattern($pattern);
    }
    
    /**
     * ����� ���������� ��������� � ������
     *
     * @param string $pattern ������� ��� ������
     */
    public function addPattern($pattern)
    {
        $this->patterns[] = $pattern;
    }
    
    /**
     * ������ �������� ������ ����� �� ���������
     *
     * @param string $request ��������� ������
     * @return string|null ���� �� �����, ���� ������ � null � ��������� ������
     */
    public function resolve($request)
    {
        foreach ($this->patterns as $filename) {
            $filename = str_replace('*', $request, $filename);
            //echo $filename . '<br>';
            if (is_file($filename)) {
                return $filename;
            }
        }
        return null;
    }
}

?>