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
 * NewsFactory: ������� ��� ��������� ������������ ��������
 *
 * @package news
 * @version 0.1
 */

class newsFactory
{
	// ��������
	private $action;
	
	// �������� �� ���������
	private $defaultAction;
	
	// ��������� �������
	private static $instance;
	
	// ����������� ��� �������
	function __construct($action)
	{
		$this->setDefaultAction('list');
		$this->setAction($action);
	}
	
	// ����� ��������� ������������ �����������
	public function getController()
	{
		$action = $this->getAction();
		fileLoader::load('news.' . $action['controller'] . '.controller');
		// ��� �������� ������� ��������� news �� ����� $this->getName
		$classname = 'news' . $action['controller'] . 'Controller';
		return new $classname();
	}
	
	// �������� ��� �������
	public static function getInstance()
	{
		if ( !isset(self::$instance) ) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	// ����� ��������� ��������
	public function setAction($action)
	{
		$this->action = $this->checkAction( $action );
	}
	
	// ����� ��������� ��������
	public function getAction()
	{
		$actions = $this->getActions();
		$this->action = $this->checkAction( $this->action );
		return $actions[$this->action];
	}
	
	// ����� ��������� ������ ��������
	private function getActions()
	{
	    // ��������, ���� ����� ��������� ������ �������� ����� ��������� �������
	    // �� �������, ������� ����� ����� ����� � ����� ���������� �� ���������
	    // ������ ���� - ���� xml, ������� ����� ���� � ������� ������
		$actions = array(
			'list' => array(
				'controller' => 'list',
			),
			'view' => array(
				'controller' => 'view',
			),
			'edit' => array(
				'controller' => 'edit',
			),
		);
		return $actions;
	}
	
	// ��������� �������� �� ���������
	public function setDefaultAction($action)
	{
		$this->defaultAction = $this->checkAction($action);
	}
	
	// ��������� �������� �� ���������
	public function getDefaultAction()
	{
		return $this->defaultAction;
	}
	
	// �������� ��������
	private function checkAction($action)
	{
		$actions = $this->getActions();
		if ( !isset( $actions[$action] ) ) {
			$action = $this->getDefaultAction();
		}
		return $action;
	}
}