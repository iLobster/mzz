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
 * NewsFactory: фабрика для получения контроллеров новостей
 *
 * @package news
 * @version 0.1
 */

class newsFactory
{
	// действие
	private $action;

	// действия
	private $actions = array();

	// действие по умолчанию
	private $defaultAction;

	// инстанция фабрики
	private static $instance;

	// конструктор для фабрики
	function __construct($action)
	{
		$this->setDefaultAction('list');
		$this->setAction($action);
	}

	// метод получения необходимого контроллера
	public function getController()
	{
		$action = $this->getAction();
		fileLoader::load('news.' . $action['controller'] . '.controller');
		// тут возможно заменим константы news на метод $this->getName
		$classname = 'news' . $action['controller'] . 'Controller';
		return new $classname();
	}

	// синглтон для фабрики
	public static function getInstance()
	{
		if ( !isset(self::$instance) ) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	// метод установки действия
	public function setAction($action)
	{
		$this->action = $this->checkAction( $action );
	}

	// метод получения действия
	public function getAction()
	{
		$actions = $this->getActions();
		$this->action = $this->checkAction( $this->action );
		return $actions[$this->action];
	}

	// метод получения списка действий
	private function getActions()
	{
	    // возможно, даже почти наверняка список действий будет выглядеть немного
	    // по другому, изменим когда будет нужно
		return $this->getActionsConfig("news");
	}

	 /**
     * Чтение XML-конфига
     *
     * @param string $section
     * @param string $action
     * @return false если требуемой секции нет
     */
    private function xmlRead($section)
    {
        $xml = simplexml_load_file(fileLoader::resolve('configs/actions.xml'));
        if (empty($this->actions) && !empty($xml->$section)) {
            foreach ($xml->$section->action as $action) {
                $this->actions[(string)$action['controller']] = array('controller' => (string)$action);
            }
        }
        return $this->actions;
    }

    /**
     * Получение всех правил
     *
     * @param string $section
     */
    public function getActionsConfig($section)
    {
        return $this->XMLread($section);
    }

	// установка действия по умолчанию
	public function setDefaultAction($action)
	{
		$this->defaultAction = $this->checkAction($action);
	}

	// получение действия по умолчанию
	public function getDefaultAction()
	{
		return $this->defaultAction;
	}

	// проверка действия
	private function checkAction($action)
	{
		$actions = $this->getActions();
		if ( !isset( $actions[$action] ) ) {
			$action = $this->getDefaultAction();
		}
		return $action;
	}
}