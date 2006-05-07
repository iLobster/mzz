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
 * action: ����� ��� ������ � actions (���������� ������)
 *
 * @package system
 * @version 0.2
*/
class action
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
     * ��� ������
     *
     * @var string
     */
    protected $module;

    /**
     * �����������
     *
     * @param string $module ��� ������
     */
    public function __construct($module)
    {
        $this->module = $module;
    }

    /**
     * ��������� ��������
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $tmp = $this->checkAction( $action );
        $this->action = $tmp['controller'];
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
     * @return array
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
     * @return array
     */
    private function iniRead($filename)
    {
        if (!file_exists($filename)) {
            throw new mzzIoException($filename);
        }
        return parse_ini_file($filename, true);
    }

    /**
     * ��������� ���� ���������� �������� ��� ������
     *
     * @return array ��� ��������� actions
     */
    protected function getActionsConfig()
    {
        if (empty($this->actions)) {
            $path = systemConfig::$pathToSystem . '/modules/' . $this->module . '/actions/';
            foreach (new mzzIniFilterIterator(new DirectoryIterator($path)) as $iterator) {
                $file = $iterator->getPath() . DIRECTORY_SEPARATOR . $iterator->getFilename();
                $type = substr($iterator->getFilename(), 0, strlen($iterator->getFilename()) - 4);
                $this->addActions($type, $this->iniRead($file));
            }
        }
        return $this->actions;
    }

    /**
     * ��������� ���� actions ��� JIP
     *
     * @return array
     */
    public function getJipActions()
    {
        $jip_actions = array();
        $actions = $this->getActions();
        foreach ($actions[$this->module] as $action) {
            if (isset($action['jip']) && $action['jip'] == true) {
                $jip_actions[] = array(
                'controller' => $action['controller'],
                'title' => $action['title'],
                'confirm' => (isset($action['confirm']) ? $action['confirm'] : null),
                );
            }
        }
        return $jip_actions;
    }

    /**
     * ��������� actions � ��� ������������. ���� action ��� ������� � ������
     * (����� ����� �� ��� � ���), �� �� ����� ��������� ����� ���������
     *
     * @param string $type ���
     * @param array $actions
     */
    public function addActions($type, Array $actions)
    {
        if (isset($this->actions[$type])) {
            $this->actions[$type] = array_merge($this->actions[$type], $actions);
        } else {
            $this->actions[$type] = $actions;
        }
    }

    /**
     * ��������� ���������� �� �������� � ������.
     * ���� �������� �� ����������, ������������� ���������� mzzSystemException
     *
     * @param string $action ��������
     * @return string
     */
    private function checkAction($action)
    {
        $actions = $this->getActions();
        foreach ($actions as $type) {
            if (isset($type[$action])) {
                return $type[$action];
            }
        }

        throw new mzzSystemException('Action ' . $action . ' not found');
    }

}

?>