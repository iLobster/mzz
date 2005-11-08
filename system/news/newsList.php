<?php
// новости - список

fileResolver::includer('news', 'newsHelper');

class newsList
{
	var $helper;
	function newsList()
	{
		$this->helper = new newsHelper();
	}
	function run()
	{
		echo 'newslist';
	}
}

?>