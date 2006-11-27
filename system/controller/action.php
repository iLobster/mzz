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
     * Тип, в котором есть установленный Action
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
     * Имя модуля
     *
     * @var string
     */
    protected $module;

    /**
     * Массив путей, по которым будут выполнен поиск
     * ini-файлов с actions-конфигурацией
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
     * ini-файлов с actions-конфигурацией
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
     * Установка действия
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
     * Возвращает действие
     *
     * @return string
     */
    public function getAction()
    {
        if (empty($this->actions) && empty($this->type)) {
            throw new mzzSystemException('Action не установлен или у модуля "' . $this->module . '" их нет.');
        }
        return $this->actions[$this->type][$this->action];
    }

    /**
     * Возвращает имя текущего экшна
     *
     * @return string
     */
    public function getActionName()
    {
        return $this->action;
    }

    /**
     * Получение всех actions для JIP
     * Actions для JIP отличаются от других наличием
     * атрибута jip = true
     *
     * @param string $type тип
     * @return array
     */
    public function getJipActions($type)
    {
        $jip_actions = array();
        $actions = $this->getActions();

        if (!isset($actions[$type])) {
            throw new mzzSystemException('Тип "' . $type . '" у модуля "' . $this->module . '" не существует.');
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
     * Добавляет actions к уже существующим. Если action уже занесен в список
     * (имеет такое же тип и имя), то он будет переписан новым значением
     *
     * @param string $type тип
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
     * Ищет действие у модуля. Бросает исключение если поиск не дал
     * результатов
     *
     * @param string $action действие
     * @return boolean
     */
    protected function findAction($action)
    {
        foreach ($this->getActions() as $type => $actions) {
            if (isset($actions[$action])) {
                return $type;
            }
        }
        throw new mzzSystemException('Действие "' . $action . '" не найдено для модуля "' . $this->module. '"');
        return false;
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
     * Чтение INI-конфига c Actions
     *
     * @param string $filename путь до INI-файла
     * @return array
     */
    private function iniRead($filename)
    {
        if (!file_exists($filename)) {
            throw new mzzIoException($filename);
        }
        $action = parse_ini_file($filename, true);
        $action['editACL'] = array('controller' => 'editACL', 'jip' => 1, 'icon' => '/templates/images/acl.gif', 'title' => 'Права доступа');
        return $action;
    }

    /**
     * возвращает тип доменного объекта, который обрабатывает текущий action
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}

?>