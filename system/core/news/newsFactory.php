<?php
// фабрика новостей

class newsFactory
{
	// возвращает объект новостей
	function get( $action )
	{
		$action = strtolower($action);
		// тут нужно поднять первую букву в вурхний регистр
		// под руками нет мануала - не помню функцию
		
		$this->checkAction( $action );
		
		fileResolver::includer('news', 'news' . $action);
		$appname = 'news' . $action;
		return new $appname();
	}
	// проверка экшна
	function checkAction( &$action )
	{
		$actions = $this->getActions();
		if ( is_array( $actions ) ) {
			if ( !isset( $actions[$action] ) ) {
				$action = $this->getDefaultAction();
			}
		} else {
			die('Нет списка экшнов для модуля news');
		}
	}
	// получение списка экшнов
	function getActions()
	{
		$file = fileResolver::resolve('news', 'actions');
		require $file;
		return $actions;
	}
	// получение имени экшна по умолчанию
	function getDefaultAction()
	{
		$file = fileResolver::resolve('news', 'actions');
		require $file;
		return $defaultAction;
	}
}

?>