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
 * NewsFactory: фабрика дл€ получени€ контроллеров новостей
 *
 * @package news
 * @version 0.3
 */
// пока здесь будет
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
     * действие по умолчанию
     *
     * @var string
     */
    protected $defaultAction;

    /**
     * Factory Instance
     *
     * @var object
     * @deprecated ??????
    private static $instance;
    */

    /**
     * »м€ модул€
     *
     * @var string
     */
    protected $name = "news"; // оставить его здесь или брать из “ћ? »ли тм должен брать отсюда?

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
     * «агрузка и создание необходимого контроллера
     *
     * @return object
     */
    public function getController()
    {
        $action = $this->getAction();
        fileLoader::load($this->name . '.' . $action['controller'] . '.controller');
        // тут возможно заменим константы news на метод $this->getName
        $classname = $this->name . $action['controller'] . 'Controller';
        return new $classname();
    }

    /**
     * Singleton
     * @deprecated ????
     * @return object

    public static function getInstance()
    {
        if ( !isset(self::$instance) ) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }
    */

    /**
     * ”становка действи€
     * ≈сли такое действие не найдено у модул€, то устанавливаетс€
     * действие по умолчанию.
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $this->checkAction( $action );
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
        return $actions[$this->action];
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
            throw new mzzRuntimeException("Cann't find file '" . $filename . "'");
        }
        $ini = parse_ini_file($filename);
        foreach ($ini as $key => $value) {
            $this->actions[$key] = array('controller' => $value);
        }
    }

    /**
     * ѕолучение всех допустимых действий дл€ модул€
     *
     * @param string $name им€ млжуд€
     */
    public function getActionsConfig()
    {
        if(empty($this->actions)) {
            foreach(new mzzIniFilterIterator(new DirectoryIterator(dirname(__FILE__)  . '/actions/')) as $iterator) {
                $file = $iterator->getPath() . DIRECTORY_SEPARATOR . $iterator->getFilename();
                $this->iniRead($file);
            }
        }
        return $this->actions;
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
        if (!isset($actions[$action])) {
            $action = $this->getDefaultAction();
        }
        return $action;
    }
}