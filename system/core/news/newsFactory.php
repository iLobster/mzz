<?php
// ������� ��������

class newsFactory
{
	// ���������� ������ ��������
	function get( $action )
	{
		$action = strtolower($action);
		// ��� ����� ������� ������ ����� � ������� �������
		// ��� ������ ��� ������� - �� ����� �������
		
		$this->checkAction( $action );
		
		fileResolver::includer('news', 'news' . $action);
		$appname = 'news' . $action;
		return new $appname();
	}
	// �������� �����
	function checkAction( &$action )
	{
		$actions = $this->getActions();
		if ( is_array( $actions ) ) {
			if ( !isset( $actions[$action] ) ) {
				$action = $this->getDefaultAction();
			}
		} else {
			die('��� ������ ������ ��� ������ news');
		}
	}
	// ��������� ������ ������
	function getActions()
	{
		$file = fileResolver::resolve('news', 'actions');
		require $file;
		return $actions;
	}
	// ��������� ����� ����� �� ���������
	function getDefaultAction()
	{
		$file = fileResolver::resolve('news', 'actions');
		require $file;
		return $defaultAction;
	}
}

?>