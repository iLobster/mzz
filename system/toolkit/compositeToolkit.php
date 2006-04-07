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

fileLoader::load('toolkit/iToolkit');

/**
 * compositeToolkit: "�����" Toolkits
 *
 * @package system
 * @version 0.1
 */
class compositeToolkit implements iToolkit
{
    /**
     * ������ c Toolkit
     *
     * @var array
     */
    private $toolkits = array();

    /**
     * �����������.
     * ��������� ����� ���������� Toolkit � ���� ����������
     * � ��������� �� � ������
     *
     */
    public function __construct()
    {
        foreach(func_get_args() as $toolkit) {
            $this->addToolkit($toolkit);
        }
    }

    /**
     * ���������� Toolkit � ������
     *
     * @param IToolkit $toolkit
     */
    public function addToolkit(IToolkit $toolkit)
    {
        array_unshift($this->toolkits, $toolkit);
    }

    /**
     * ���������� toolkit
     *
     * @param string $toolName
     * @return object|false
     */
    public function getToolkit($toolName)
    {
        foreach($this->toolkits as $toolkit) {
            if  ($tool = $toolkit->getToolkit($toolName)) {
                return $tool;
            }
        }
        return false;
    }
}
?>