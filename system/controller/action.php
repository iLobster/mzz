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

fileLoader::load('iterators/mzzIniFilterIterator');

/**
 * action: ����� ��� ������ � actions (���������� ������)
 *
 * @package system
 * @version 0.3
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
     * ���, � ������� ���� ������������� Action
     *
     * @var string
     */
    protected $type = null;

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
     * ������ �����, �� ������� ����� �������� �����
     * ini-������ � actions-�������������
     *
     * @var array
     * @see addPath()
     */
    protected $paths = array();

    /**
     * �����������
     *
     * @param string $module ��� ������
     */
    public function __construct($module)
    {
        $this->module = $module;

        $this->addPath(systemConfig::$pathToSystem . '/modules/' . $this->module . '/actions/');
        $this->addPath(systemConfig::$pathToApplication . '/modules/' . $this->module . '/actions/');
    }

    /**
     * ��������� ���� � ������� � ������, �� ������� ����� �������� �����
     * ini-������ � actions-�������������
     *
     * @param string $path
     */
    public function addPath($path)
    {
        if (in_array($path, $this->paths)) {
            throw new mzzRuntimeException('Path "' . $path . '" already in Action.');
        }
        $this->paths[] = $path;
    }

    /**
     * ��������� ��������
     *
     * @param string $action
     */
    public function setAction($action)
    {
        if ($this->type = $this->findAction($action)) {
            $this->action = $action;
        }
    }

    /**
     * ���������� ��������
     *
     * @return string
     */
    public function getAction()
    {
        if (empty($this->actions) && empty($this->type)) {
            throw new mzzSystemException('Action �� ���������� ��� � ������ "' . $this->module . '" �� ���.');
        }
        return $this->actions[$this->type][$this->action];
    }

    /**
     * ���������� ��� �������� �����
     *
     * @return string
     */
    public function getActionName()
    {
        return $this->action;
    }

    /**
     * ��������� ���� actions ��� JIP
     * Actions ��� JIP ���������� �� ������ ��������
     * �������� jip = true
     *
     * @param string $type ���
     * @return array
     */
    public function getJipActions($type)
    {
        $jip_actions = array();
        $actions = $this->getActions();

        if (!isset($actions[$type])) {
            throw new mzzSystemException('��� "' . $type . '" � ������ "' . $this->module . '" �� ����������.');
        }

        foreach ($actions[$type] as $key => $action) {
            if (isset($action['jip']) && $action['jip'] == true) {
                $jip_actions[$key] = array(
                'controller' => $action['controller'],
                'title' => (isset($action['title']) ? $action['title'] : null),
                'icon' => (isset($action['icon']) ? $action['icon'] : null),
                'confirm' => (isset($action['confirm']) ? $action['confirm'] : null),
                'isPopup' => (isset($action['isPopup']) ? $action['isPopup'] : null)
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
    protected function addActions($type, array $actions)
    {
        if (isset($this->actions[$type])) {
            $this->actions[$type] = array_merge($this->actions[$type], $actions);
        } else {
            $this->actions[$type] = $actions;
        }
    }

    /**
     * ���� �������� � ������. ������� ���������� ���� ����� �� ���
     * �����������
     *
     * @param string $action ��������
     * @return boolean
     */
    protected function findAction($action)
    {
        foreach ($this->getActions() as $type => $actions) {
            if (isset($actions[$action])) {
                return $type;
            }
        }
        throw new mzzSystemException('�������� "' . $action . '" �� ������� ��� ������ "' . $this->module. '"');
        return false;
    }

    /**
     * ���������� ��� ���������� �������� ������
     *
     * @param boolean $onlyACL ������� ������ ACL ��������
     * @return array
     */
    public function getActions($onlyACL = false)
    {
        if (empty($this->actions)) {
            foreach ($this->paths as $path) {
                if (!is_dir($path)) {
                    continue;
                }
                foreach (new mzzIniFilterIterator(new DirectoryIterator($path)) as $iterator) {
                    $fileName = $iterator->getFilename();
                    $type = substr($fileName, 0, strlen($fileName) - 4);
                    $this->addActions($type, $this->iniRead($iterator->getPath() . '/' . $fileName));
                }
            }
        }

        if ($onlyACL) {
            $tmp = array();
            foreach ($this->actions as $key => $val) {
                foreach ($val as $subkey => $subval) {
                    if (!isset($subval['inACL']) || $subval['inACL'] == 1) {
                        $tmp[$key][$subkey] = $subval;
                    }
                }
            }
            return $tmp;
        }

        return $this->actions;
    }

    /**
     * ������ INI-������� c Actions
     *
     * @param string $filename ���� �� INI-�����
     * @return array
     */
    private function iniRead($filename)
    {
        if (!file_exists($filename)) {
            throw new mzzIoException($filename);
        }
        $action = parse_ini_file($filename, true);
        $action['editACL'] = array('controller' => 'editACL', 'jip' => 1, 'icon' => '/templates/images/acl.gif', 'title' => '����� �������');
        return $action;
    }

    /**
     * ���������� ��� ��������� �������, ������� ������������ ������� action
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}

?>