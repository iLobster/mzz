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

fileLoader::load('simple/simpleAction');

/**
 * simpleModule: abstract class for modules
 *
 * @package modules
 * @subpackage simple
 * @version 0.0.4
 */
abstract class simpleModule
{
    const OVERRIDE_PREFIX = 'app';

    /**
     * Name of the module
     *
     * @var string
     */
    protected $moduleName = null;
    protected $moduleTitle = null;

    /**
     * Array of classes of the module
     *
     * @var array
     */
    protected $classes = array();

    /**
     * Actions array
     *
     * @var array|null
     */
    protected $actions = null;

    protected $roles = array();

    /**
     * Array of mappers objects
     *
     * @var array
     */
    protected $mappers = array();

    /**
     * Array of the paths where we going to search module files
     *
     * @var array
     */
    protected $paths = array();

    public function __construct()
    {
        $this->paths = array(
            'sys' => systemConfig::$pathToSystem . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $this->getName(),
            'app' => systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $this->getName()
        );
    }

    /**
     * Get name of the module
     *
     * @return string
     */
    public final function getName()
    {
        if (is_null($this->moduleName)) {
            $patterns = array(
                '!^' . self::OVERRIDE_PREFIX . '!',
                '!Module$!'
            );

            $name = preg_replace($patterns, '', get_class($this));
            $name = strtolower($name[0]) . substr($name, 1);
            $this->moduleName = $name;
        }

        return $this->moduleName;
    }

    /**
     * Get mapper for the specified class
     *
     * @param string $className
     * @return object
     */
    public function getMapper($className)
    {
        if (!in_array($className, $this->getClasses())) {
            throw new mzzUndefinedModuleClassException($this->getName(), $className);
        }

        if (!isset($this->mappers[$className])) {
            $mapperName = $className . 'Mapper';
            if (!class_exists($mapperName)) {
                fileLoader::load($this->getName() . '/mappers/' . $mapperName);
            }

            //@todo: прикрутить сюда кэширование, чтобы не тыкаться в ФС каждый раз!
            $projectMapperName = self::OVERRIDE_PREFIX . ucfirst($mapperName);
            try {
                fileLoader::load($this->getName() . '/mappers/' . $projectMapperName);
                $mapperName = $projectMapperName;
            } catch (mzzIoException $e) {}

            $mapperClass = new $mapperName();
            //@todo: вероятно, это лучше передавать через конструктор
            $mapperClass->setModule($this->getName());
            $this->mappers[$className] = $mapperClass;
        }

        return $this->mappers[$className];
    }

    /**
     * Return module classes
     *
     * @return array
     */
    public final function getClasses()
    {
        return $this->classes;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Return all actions of the module
     *
     * @return array
     */
    public function getActions()
    {
        if (is_null($this->actions)) {
            $actions = array();
            foreach ($this->classes as $className) {
                $actionsDataFile = $this->paths['sys'] . '/actions/' . $className . '.php';
                $actionsData = array();
                if (is_file($actionsDataFile)) {
                    $actionsData = include $actionsDataFile;
                }

                $projectActionsDataFile = $this->paths['app'] . '/actions/' . $className . '.php';

                if (is_file($projectActionsDataFile)) {
                    $projectActionsData = include $projectActionsDataFile;
                    if (is_array($projectActionsData)) {
                        $actionsData = array_merge($actionsData, $projectActionsData);
                    }
                }

                if (is_array($actionsData)) {
                    $actionsObjects = array();
                    foreach ($actionsData as $actionName => $data) {
                        if (!empty($data)) {
                            $actionsObjects[$actionName] = $this->createActionByArray($actionName, $className, $data);
                        }
                    }

                    $actions += $actionsObjects;
                }
            }

            $this->actions = $actions;
        }

        return $this->actions;
    }

    /**
     * Return actions of the specfied class
     *
     * @param string $className
     * @return array
     */
    public function getClassActions($className)
    {
        if (!in_array($className, $this->getClasses())) {
            throw new mzzUndefinedModuleClassException($this->getName(), $className);
        }

        $allActions = $this->getActions();

        $actions = array();
        foreach ($allActions as $actionName => $action) {
            if ($action->getClassName() == $className) {
                $actions[$actionName] = $action;
            }
        }

        return $actions;
    }

    /**
     * Return action by name
     *
     * @param string $actionName
     * @throws mzzUnknownModuleActionException
     * @return object
     */
    public function getAction($actionName)
    {
        $actions = $this->getActions();

        if (!isset($actions[$actionName])) {
            throw new mzzUnknownModuleActionException($this->getName(), $actionName);
        }

        return $actions[$actionName];
    }

    protected function createActionByArray($actionName, $className, Array $data)
    {
        $controllerName = $data['controller'];
        unset($data['controller']);

        return new simpleAction($actionName, $this->getName(), $className, $controllerName, $data);
    }

    /**
     * Title of the module
     *
     * @todo сделать вменяемо, с i18n и прочим
     * @return string
     */
    public function getTitle()
    {
        if (is_null($this->moduleTitle)) {
            $key = '_ ' . $this->getName();
            $title = i18n::getMessage($key, $this->getName());
            if ($title == $key) {
                $title = $this->getName();
            }

            $this->moduleTitle = $title;
        }

        return $this->moduleTitle;
    }
}
?>