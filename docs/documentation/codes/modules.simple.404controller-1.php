<?php

class simple404Controller extends simpleController
{
    protected function getView()
    {
        $this->request->setSection('page');
        $this->request->setParams(array('name' => '404'));
        $this->request->setAction('view');

        $action = $this->toolkit->getAction('page');
        $action->setAction('view');

        fileLoader::load('pageFactory');

        $factory = new pageFactory($action);
        $controller = $factory->getController();

        $this->toolkit->getResponse()->setHeader('', 'HTTP/1.x 404 Not Found');

        return $controller->run();
    }
}

?>