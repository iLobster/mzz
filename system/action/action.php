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
 * action: класс дл€ работы с actions
 *
 * @package system
 * @version 0.1
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

    protected $module;


    /**
     * действие по умолчанию
     *
     * @var string
     */
    private $defaultAction;

    public function __construct($module, $action)
    {
        $this->module = $module;
        $this->setAction($action);
    }
    /**
     * ”становка действи€
     * ≈сли такое действие не найдено у модул€, то устанавливаетс€
     * действие по умолчанию.
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $tmp = $this->checkAction( $action );
        $this->action = $tmp['controller'];
    }

    /**
     * ¬озвращает действие
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
     * ¬озвращает все допустимые действи€
     *
     * @return string
     */
    private function getActions()
    {
        // возможно, даже почти наверн€ка список действий будет выгл€деть немного
        // по другому, изменим когда будет нужно
        return $this->getActionsConfig();
    }

    /**
     * „тение INI-конфига
     *
     * @param string $filename путь до INI-файла
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
     * ѕолучение всех допустимых действий дл€ модул€
     *
     * @param string $name им€ млжуд€
     */
    protected function getActionsConfig()
    {
        if(empty($this->actions)) {
            $path = systemConfig::$pathToSystem . 'modules/' . $this->module . '/actions/';
            foreach(new mzzIniFilterIterator(new DirectoryIterator($path)) as $iterator) {
                $file = $iterator->getPath() . DIRECTORY_SEPARATOR . $iterator->getFilename();
                $type = substr($iterator->getFilename(), 0, strlen($iterator->getFilename()) - 4);
                $this->addActions($type, $this->iniRead($file));
            }
        }
        return $this->actions;
    }

    public function getJipActions()
    {
        $jip_actions = array();
        $actions = $this->getActions();
        foreach ($actions[$this->module] as $action) {
            if(isset($action['jip']) && $action['jip'] == true) {
                $jip_actions[] = array('controller' => $action['controller'], 'title' => $action['title']);
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
    /**
     * ”станавливает действие по умолчанию
     *
     * @param string $action
     */
    public function setDefaultAction($action)
    {
        $this->defaultAction = $this->checkAction($action);
    }

    /**
     * ¬озвращает действие по умолчанию
     *
     * @return string
     */
    public function getDefaultAction()
    {
        return $this->defaultAction;
    }

    /**
     * ѕровер€ет существует ли действие у модул€.
     * ≈сли действие не существует, возвращаетс€ действие по умолчанию
     *
     * @param string $action действие
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
        return $this->getDefaultAction();
    }

}

?>