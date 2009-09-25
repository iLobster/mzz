<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('user/mappers/userRoleMapper');

/**
 * simpleAction: class for action
 *
 * @package modules
 * @subpackage simple
 * @version 0.0.1
 */
class simpleAction
{
    const DEFAULT_ACTIVE_TPL = 'active.main.tpl';

    /**
     * Action name
     *
     * @var string
     */
    protected $name;

    /**
     * Action module
     *
     * @var string
     */
    protected $moduleName;

    /**
     * Action class
     *
     * @var string
     */
    protected $className;

    /**
     * Action controller
     *
     * @var string
     */
    protected $controllerName;

    /**
     * Controllers
     *
     * @var array
     */
    protected $controllers = array();

    /**
     * Action data
     *
     * @var array
     */
    protected $data = array();

    /**
     * Constructor
     *
     * @param string $moduleName action module
     * @param string $className action class
     * @param string $actionName name of the requested action
     * @param string $controllerName action controller
     * @param array $data action data
     */
    public function __construct($name, $moduleName, $className, $controllerName, Array $data = array())
    {
        $this->name = $name;
        $this->moduleName = $moduleName;
        $this->className = $className;
        $this->controllerName = $controllerName;
        $this->data = $data;
    }

    /**
     * Return action name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return the module name
     *
     * @return string
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * Return the class name
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Return the controller name
     *
     * @return string
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * Return active template
     *
     * @return string
     */
    public function getActiveTemplate()
    {
        return (isset($this->data['main'])) ? $this->data['main'] : self::DEFAULT_ACTIVE_TPL;
    }

    /**
     * Return title for the action
     *
     * @return string
     */
    public function getTitle()
    {
        if (isset($this->data['title'])) {
            return $this->data['title'];
        }
    }

    public function getIcon()
    {
        if (isset($this->data['icon'])) {
            return $this->data['icon'];
        }
    }

    public function isLang()
    {
        return (isset($this->data['lang']) && $this->data['lang']);
    }

    /**
     * Is this a jip action?
     *
     * @return boolean
     */
    public function isJip()
    {
        return isset($this->data['jip']) && $this->data['jip'] > 0;
    }

    /**
     * Return jip menu_id
     *
     * @return integer
     */
    public function getJipMenuId()
    {
        return ($this->isJip()) ? $this->data['jip'] : 0;
    }

    /**
     * Return confirmation message
     *
     * @return string
     */
    public function getConfirm()
    {
        if (isset($this->data['confirm'])) {
            return $this->data['confirm'];
        }
    }

    /**
     * Return additional data of action
     *
     * @param mixed $key
     * @return mixed
     */
    public function getData($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     * Return all data of action
     *
     * @return mixed
     */
    public function getAllData()
    {
        return $this->data;
    }

    /**
     * Run action
     *
     * @return string
     */
    public function run()
    {
        $controller = $this->getController();
        return $controller->run();
    }

    /**
     * Get controller for action
     *
     * @return object
     */
    protected function getController()
    {
        $name = $this->getControllerName();
        if (!isset($this->controllers[$name])) {
            $controllerClassName = $this->moduleName . ucfirst($name) . 'Controller';
            fileLoader::load($this->moduleName . '/controllers/' . $controllerClassName);
            $this->controllers[$name] = new $controllerClassName($this);
        }

        return $this->controllers[$name];
    }

    /**
     * Return roles
     *
     * @return string
     */
    private function getRoles()
    {
        return (isset($this->data['role'])) ? $this->data['role'] : null;
    }

    public function isAdmin()
    {
        return !empty($this->data['admin']);
    }

    public function isDashboard()
    {
        return !empty($this->data['dashboard']);
    }

    public function canRun()
    {
        $roleMapper = systemToolkit::getInstance()->getModule('user')->getMapper('userRole');
        return $roleMapper->hasRole($this->moduleName, $this->getRoles());
    }
}
?>