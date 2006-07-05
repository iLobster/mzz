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
     * @see addPath
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
        //echo $this->module . ' =========== ' . $this->action;
        return $this->actions[$this->type][$this->action];
    }

    /**
     * ��������� ���� actions ��� JIP
     * Actions ��� JIP ���������� �� ������ ��������
     * �������� jip = true
     *
     * @return array
     */
    public function getJipActions()
    {
        $jip_actions = array();
        $actions = $this->getActions();
        foreach ($actions as $typeActions) {
            foreach ($typeActions as $action) {
                if (isset($action['jip']) && $action['jip'] == true) {
                    $jip_actions[] = array(
                    'controller' => $action['controller'],
                    'title' => (isset($action['title']) ? $action['title'] : null),
                    'confirm' => (isset($action['confirm']) ? $action['confirm'] : null),
                    );
                }
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
        throw new mzzSystemException('Action "' . $action . '" not found for module "' . $this->module. '"');
        return false;
    }

    /**
     * ���������� ��� ���������� �������� ������
     *
     * @return array
     */
    private function getActions()
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
        return parse_ini_file($filename, true);
    }
}



/*


class action
{
    protected $action;


    protected $actions = array();

    protected $module;

    protected $paths = array();


    public function __construct($module)
    {
        $this->module = $module;

        $this->addPath(systemConfig::$pathToSystem . '/modules/' . $this->module . '/actions/');
        $this->addPath(systemConfig::$pathToApplication . '/modules/' . $this->module . '/actions/');
    }

    public function addPath($path)
    {
        if (in_array($path, $this->paths)) {
            throw new mzzRuntimeException('Path "' . $path . '" already in Action.');
        }
        $this->paths[] = $path;
    }

    public function setAction($action)
    { debug_print_backtrace();
        $tmp = $this->checkAction( $action );
        $this->action = $tmp['controller'];
    }

    public function getAction()
    {
        $actions = $this->getActions();
        $this->action = $this->checkAction($this->action);

        return $this->action;
    }

    private function getActions()
    {
    // ��������, ���� ����� ��������� ������ �������� ����� ��������� �������
    // �� �������, ������� ����� ����� �����
    return $this->getActionsConfig();
    }

    private function iniRead($filename)
    {
        if (!file_exists($filename)) {
            throw new mzzIoException($filename);
        }
        return parse_ini_file($filename, true);
    }

    protected function getActionsConfig()
    {
        if (empty($this->actions)) {
            foreach ($this->paths as $path) {
                if (!is_dir($path)) {
                    continue;
                }
                foreach (new mzzIniFilterIterator(new DirectoryIterator($path)) as $iterator) {
                    $file = $iterator->getPath() . DIRECTORY_SEPARATOR . $iterator->getFilename();
                    $type = substr($iterator->getFilename(), 0, strlen($iterator->getFilename()) - 4);
                    $this->addActions($type, $this->iniRead($file));
                }
            }
        }
        return $this->actions;
    }

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

    public function addActions($type, Array $actions)
    {
        if (isset($this->actions[$type])) {
            $this->actions[$type] = array_merge($this->actions[$type], $actions);
        } else {
            $this->actions[$type] = $actions;
        }
    }

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
*/
?>