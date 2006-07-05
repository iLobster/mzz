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
 * simpleFactory: �������
 *
 * @package simple
 * @version 0.1
 */
abstract class simpleFactory
{
    /**
     * Module action
     *
     * @var string
     */
    protected $action;

    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = "simple"; // �������� ��� ����� ��� ����� �� ��? ��� �� ������ ����� ������?

    /**
     * Constructor
     *
     * @param string $action
     */
    public function __construct($action)
    {
        $this->action = $action;
    }

    /**
     * �������� � �������� ������������ �����������
     *
     * @return object
     */
    public function getController()
    {
        $action = $this->action->getAction();
        fileLoader::load($this->name . '/controllers/' . $this->name . '.' . $action['controller'] . '.controller');
        // ��� �������� ������� ��������� news �� ����� $this->getName
        $classname = $this->name . ucfirst($action['controller']) . 'Controller';
        return new $classname();
    }


}
?>