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
 * userFactory: ������� ��� ��������� ������������ ��� user
 *
 * @package user
 * @version 0.1
 */

class userFactory
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
    protected $name = "user"; // �������� ��� ����� ��� ����� �� ��? ��� �� ������ ����� ������?

    /**
     * Constructor
     *
     * @param string $action
     */
    public function __construct($action)
    {
        $this->action = $action;
        //$this->action->setDefaultAction('list');
        //$this->action->setAction($action->getAction());
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