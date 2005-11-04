<?php
// ядро

fileResolver::includer('config', 'configFactory');
fileResolver::includer('request', 'requestParser');
fileResolver::includer('errors', 'error');

class core
{
	// запуск приложения
	function run()
	{
		//$config = configFactory::get();
		$requestParser = requestParser::getInstance();

		$application = $requestParser->get('section');
		$action = $requestParser->get('action');

		// переложить выбор приложения на вспомогательный класс
		// сделал как быстрее - тут важна не реализация а принцип
		/*
		$path = $_GET['path'];
		preg_match('/^([^\/]*)(\/)?/',$path,$matches);
		$application = $matches[1];
		$path = preg_replace('/^([^\/]*)(\/)?/','',$path);
		preg_match('/\/?([^\/]+)$/U',$path,$matches);
		$action = $matches[1];*/

		fileResolver::includer($application, $application . 'Factory');
		$factoryname = $application . 'Factory';
		$factory = new $factoryname();
		$app = $factory->get($action);
		$app->run();
	}
}

?>