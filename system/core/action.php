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
    /**
     * Module action
     *
     * @var string
     */
    protected $action;

    /**
     * Класс, в котором есть установленный Action
     *
     * @var string
     */
    protected $class = null;

    /**
     * Module actions
     *
     * @var array
     */
    protected $actions = array();

    /**
     * Имя модуля
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
    }

    /**
     * Установка действия
     *
     * @param string $action
     */
    public function setAction($action)
    {
        if ($this->class = $this->findAction($action)) {
            $this->action = $action;
        }
    }

    /**
     * Возвращает действие
     *
     * @return string
     */
    public function getAction()
    {
        if (empty($this->actions) && empty($this->class)) {
            throw new mzzSystemException('Action не установлен или у модуля "' . $this->module . '" нет такого действия.');
        }
        return $this->actions[$this->class][$this->action];
    }

    /**
     * Возвращает имя текущего экшна
     *
     * @return string
     */
    public function getActionName($getAlias = false)
    {
        if ($getAlias && isset($this->actions[$this->class][$this->action]['alias'])) {
            return $this->actions[$this->class][$this->action]['alias'];
        }
        return $this->action;
    }

    /**
     * Получение всех actions для JIP
     * Actions для JIP отличаются от других наличием
     * атрибута jip = true
     *
     * @param string $class
     * @return array
     */
    public function getJipActions($class)
    {
        $actions = $this->getActions();

        if (!isset($actions[$class])) {
            throw new mzzSystemException('Класс "' . $class . '" у модуля "' . $this->module . '" не существует.');
        }

        $jip_actions = $actions[$class];
        foreach ($jip_actions as $key => $action) {
            if ($this->isJip($action)) {
                unset($jip_actions[$key]['jip']);
            } else {
                unset($jip_actions[$key]);
            }
        }

        return $jip_actions;
    }

    /**
     * Возвращает все допустимые действия модуля
     *
     * @param boolean $onlyACL выбрать только ACL действия
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
                    $class = substr($fileName, 0, strlen($fileName) - 4);
                    $this->addActions($class, $this->prepareActionsConfig($iterator->getPath() . '/' . $fileName));
                }
            }
        }

        if ($onlyACL) {
            $tmp = array();
            foreach ($this->actions as $key => $val) {
                foreach ($val as $subkey => $subval) {
                    if ($this->isAclAction($subkey, $subval)) {
                        $tmp[$key][$subkey] = $subval;
                    }
                }
            }
            return $tmp;
        }

        return $this->actions;
    }

    /**
     * возвращает имя класса доменного объекта, который обрабатывает текущий action
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * возвращает true если у действия $action имеется атрибут jip = true
     *
     * @param array $action массив с данными о действии
     * @return boolean
     */
    public function isJip(Array $action)
    {
        return isset($action['jip']) && $action['jip'] == true;
    }

    protected function isAclAction($name, $params)
    {
        if (!isset($params['403handle']) && $name == 'admin') {
            return false;
        }

        return !isset($params['alias']) &&  (!isset($params['403handle']) || $params['403handle'] != 'none');
    }

    /**
     * Добавляет actions к уже существующим. Если action уже занесен в список
     * (имеет такой же класс и имя), то он будет переписан новым значением
     *
     * @param string $class
     * @param array $actions
     */
    protected function addActions($class, array $actions)
    {
        if (isset($this->actions[$class])) {
            $this->actions[$class] = array_merge($this->actions[$class], $actions);
        } else {
            $this->actions[$class] = $actions;
        }
    }

    /**
     * Ищет действие у модуля. Бросает исключение если поиск не дал
     * результатов
     *
     * @param string $action действие
     * @return boolean
     */
    protected function findAction($action)
    {
        foreach ($this->getActions() as $class => $actions) {
            if (isset($actions[$action])) {
                return $class;
            }
        }
        throw new mzzSystemException('Действие "' . $action . '" не найдено для модуля "' . $this->module. '"');
        return false;
    }

    /**
     * Чтение INI-конфига c Actions
     *
     * @param string $filename путь до INI-файла
     * @return array
     */
    private function prepareActionsConfig($filename)
    {
        if (!file_exists($filename)) {
            throw new mzzIoException($filename);
        }
        $action = parse_ini_file($filename, true);
        $action['editACL'] = array('controller' => 'editACL', 'jip' => 1, 'icon' => '/templates/images/acl.gif', 'title' => '_ editACL');
        return $action;
    }
}

?>