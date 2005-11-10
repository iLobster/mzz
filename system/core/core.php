<?php
// ядро

fileResolver::includer('config', 'configFactory');
fileResolver::includer('request', 'requestParser');
fileResolver::includer('frontcontroller', 'frontcontroller');
fileResolver::includer('errors', 'error');
fileResolver::includer('template', 'mzzSmarty');
fileResolver::includer('core', 'File');
class core
{
	// запуск приложения
	function run()
	{
		//$config = configFactory::get();
		$requestParser = requestParser::getInstance();

		$application = $requestParser->get('section');
		$action = $requestParser->get('action');
		
		$action = 'list';

        	$frontcontroller = new frontController($application, $action);
        	$template = $frontcontroller->getTemplate();
        	//echo $template.'<br>';
		$smarty = mzzSmarty::getInstance();

		echo $smarty->fetch($template);

		/*
		fileResolver::includer($application, $application . 'Factory');
		$factoryname = $application . 'Factory';
		$factory = new $factoryname();
		$app = $factory->get($action);
		$app->run(); */
	}
}

?>