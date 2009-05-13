<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * action: класс для работы с actions (действиями модуля)
 *
 * @package system
 * @version 0.3
*/
class action
{
    const DEFAULT_ACTIVE_TPL = 'active.main.tpl';

    /**
     * Module's actions
     *
     * @var array
     */
    protected $actions = array();

    /**
     * Module name
     *
     * @var string
     */
    protected $module;

    /**
     * Массив путей, по которым будут выполнен поиск
     * ini-файлов с описанием действий модуля
     *
     * @var array
     * @see addPath()
     */
    protected $paths = array();

    /**
     * Конструктор
     *
     * @param string $module имя модуля
     */
    public function __construct($module)
    {
        $this->module = $module;

        $this->addPath(systemConfig::$pathToSystem . '/modules/' . $this->module . '/actions/');
        $this->addPath(systemConfig::$pathToApplication . '/modules/' . $this->module . '/actions/');
    }

    /**
     * Добавляет путь к массиву с путями, по которым будут выполнен поиск
     * ini-файлов с описанием действий модуля
     *
     * @param string $path
     */
    public function addPath($path)
    {
        if (in_array($path, $this->paths)) {
            throw new mzzRuntimeException('Path "' . $path . '" already added.');
        }
        $this->paths[] = $path;

        $this->buildActionsConfigs();
    }

    public function getOptions($action)
    {
        $options = $this->findOptions($action);
        return $options['options'];
    }

    /**
     * возвращает имя класса доменного объекта
     *
     * @return string
     */
    public function getClass($action)
    {
        $options = $this->findOptions($action);
        return $options['class'];
    }

    /**
     * Возвращает имя экшена или его алиас
     *
     * @return string
     */
    public function getAlias($action)
    {
        if (isset($this->actions[$this->getClass($action)][$action]['alias'])) {
            return $this->actions[$this->getClass($action)][$action]['alias'];
        }
        return $action;
    }

    /**
     * Возвращает имя активного шаблона
     *
     * @return array
     */
    public function getActiveTemplate($action)
    {
        if (isset($this->actions[$this->getClass($action)][$action]['main'])) {
            return $this->actions[$this->getClass($action)][$action]['main'];
        }

        return action::DEFAULT_ACTIVE_TPL;
    }

    /**
     * Возвращает все допустимые действия модуля
     *
     * @param boolean $onlyACL выбрать только ACL действия
     * @return array
     */
    public function getActions($filter = array())
    {

        if (!empty($filter)) {
            $tmp = array();
            foreach ($this->actions as $class => $params) {
                foreach ($params as $action => $options) {
                    if ((isset($filter['acl']) && $this->isAclAction($action, $options))
                    || (isset($filter['jip']) && $this->isJip($options, $filter['jip']))
                    || (isset($filter['admin']) && isset($options['admin']))
                    || (isset($filter['class']) && $class == $filter['class'] && count($filter) == 1)) {
                        $tmp[$class][$action] = $options;
                    }
                }
                if (isset($filter['class']) && $class == $filter['class']) {
                    return isset($tmp[$class]) ? $tmp[$class] : array();
                }
            }
            return $tmp;
        }

        return $this->actions;
    }

    /**
     * возвращает true если у действия $action имеется атрибут jip со значением $id
     *
     * @param string|array $action имя действия или массив с данными о действии
     * @return boolean
     */
    public function isJip($options, $id = 1)
    {
        if (!is_array($options)) {
            $options = $this->getOptions($options);
        }
        return isset($options['jip']) && (int)$options['jip'] === $id;
    }

    protected function isAclAction($name, $params)
    {
        if (!isset($params['403handle']) && $name == 'admin') {
            return false;
        }

        return !isset($params['alias']) && (!isset($params['403handle']) || $params['403handle'] != 'none');
    }

    /**
     * Ищет действие у модуля.
     *
     * @param string $action действие
     * @return boolean
     */
    protected function findOptions($action)
    {
        foreach ($this->actions as $class => $actions) {
            if (isset($actions[$action])) {
                return array('class' => $class, 'options' => $actions[$action]);
            }
        }

        throw new mzzNoActionException('The "' . $this->module . '" module doesn\'t have the "' . $action . '" action');
    }

    protected function buildActionsConfigs()
    {
        foreach ($this->paths as $key => $path) {
            if (!is_dir($path)) {
                continue;
            }
            foreach (new mzzIniFilterIterator(new DirectoryIterator($path)) as $iterator) {
                $fileName = $iterator->getFilename();
                $class = substr($fileName, 0, strlen($fileName) - 4);
                $action = parse_ini_file($iterator->getPath() . '/' . $fileName, true);
                $this->addEditAclAction($action);
                $this->addActionsToClass($class, $action);
                unset($this->paths[$key]);
            }
        }
    }

    protected function addEditAclAction(array & $action)
    {
        $action['editACL'] = array(
            'controller' => 'editACL',
            'jip' => 1,
            'icon' => '/templates/images/acl.gif',
            'title' => '_ editACL');
    }

    /**
     * Добавляет actions к уже существующим. Если action уже занесен в список
     * (имеет такой же класс и имя), то он будет переписан новым значением
     *
     * @param string $class
     * @param array $actions
     */
    protected function addActionsToClass($class, array $actions)
    {
        if (isset($this->actions[$class])) {
            $this->actions[$class] = array_merge($this->actions[$class], $actions);
        } else {
            $this->actions[$class] = $actions;
        }
    }
}

?>