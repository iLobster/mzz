<?php

class simple403Controller extends simpleController
{
    public function getView()
    {
        $this->request->setSection('page');
        $this->request->setParams(array('name' => '403'));
        $this->request->setAction('view');

        $action = $this->toolkit->getAction('page');
        $action->setAction('view');

        fileLoader::load('pageFactory');

        $factory = new pageFactory($action);
        $controller = $factory->getController();

        $this->toolkit->getResponse()->setHeader('', 'HTTP/1.x 403 Forbidden');

        return $controller->run();
    }
}

?>