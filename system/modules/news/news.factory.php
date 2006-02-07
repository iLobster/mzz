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
 * NewsFactory: ������� ��� ��������� ������������ ��������
 *
 * @package news
 * @version 0.3
 */
// ���� ����� �����
class mzzIniFilterIterator extends FilterIterator {
    function accept() {
        return $this->isFile() && (substr($tmp = $this->getFilename(), -3) == 'ini');
    }
}

class newsFactory
{
    /**
     * Module action
     *
     * @var string
     */
    protected $action;

    /**
     * Module actions
     *
     * @var array
     */
    protected $actions = array();

    /**
     * �������� �� ���������
     *
     * @var string
     */
    protected $defaultAction;

    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = "news"; // �������� ��� ����� ��� ����� �� ��? ��� �� ������ ����� ������?

    /**
     * Constructor
     *
     * @param string $action
     */
    public function __construct($action)
    {
        $this->setDefaultAction('list');
        $this->setAction($action);
    }

    /**
     * �������� � �������� ������������ �����������
     *
     * @return object
     */
    public function getController()
    {
        $action = $this->getAction();
        fileLoader::load($this->name . '/controllers/' . $this->name . '.' . $action['controller'] . '.controller');
        // ��� �������� ������� ��������� news �� ����� $this->getName
        $classname = $this->name . $action['controller'] . 'Controller';
        return new $classname();
    }

    /**
     * ��������� ��������
     * ���� ����� �������� �� ������� � ������, �� ���������������
     * �������� �� ���������.
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $this->checkAction( $action );
        ///echo $this->action;
    }

    /**
     * ���������� ��������
     *
     * @return string
     */
    public function getAction()
    {
        $actions = $this->getActions();
        $this->action = $this->checkAction($this->action);

        return $this->action;
    }

    /**
     * ���������� ��� ���������� ��������
     *
     * @return string
     */
    private function getActions()
    {
        // ��������, ���� ����� ��������� ������ �������� ����� ��������� �������
        // �� �������, ������� ����� ����� �����
        return $this->getActionsConfig();
    }

    /**
     * ������ INI-�������
     *
     * @param string $filename ���� �� INI-�����
     * @return string
     */
    private function iniRead($filename)
    {
        if(!file_exists($filename)) {
            throw new mzzIoException($filename);
        }
        return parse_ini_file($filename, true);
    }

    /**
     * ��������� ���� ���������� �������� ��� ������
     *
     * @param string $name ��� ������
     */
    public function getActionsConfig()
    {
        if(empty($this->actions)) {
            foreach(new mzzIniFilterIterator(new DirectoryIterator(dirname(__FILE__) . '/actions/')) as $iterator) {
                $file = $iterator->getPath() . DIRECTORY_SEPARATOR . $iterator->getFilename();
                $type = substr($iterator->getFilename(), 0, strlen($iterator->getFilename()) - 4);
                $this->addActions($type, $this->iniRead($file));
            }
        }
        return $this->actions;
    }

    public function addActions($type, Array $actions)
    {
        if (isset($this->actions[$type])) {
            $this->actions[$type] = array_merge($this->actions[$type], $actions);
        } else {
            $this->actions[$type] = $actions;
        }
    }
    /**
     * ������������� �������� �� ���������
     *
     * @param string $action
     */
    public function setDefaultAction($action)
    {
        $this->defaultAction = $this->checkAction($action);
    }

    /**
     * ���������� �������� �� ���������
     *
     * @return string
     */
    public function getDefaultAction()
    {
        return $this->defaultAction;
    }

    /**
     * ��������� ���������� �� �������� � ������.
     * ���� �������� �� ����������, ������������ �������� �� ���������
     *
     * @param string $action ��������
     * @return string
     */
    private function checkAction($action)
    {
       if(is_array($action)) { debug_print_backtrace(); }
        $actions = $this->getActions();
        foreach ($actions as $type) {
            if (isset($type[$action])) {
                return $type[$action];
            }
        }
        //return $type[$action];
        return $this->getDefaultAction();
    }
}