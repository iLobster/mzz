<?php

class systemToolkit
{
    private static $instance = false;

    private $toolkit;

    public static function getInstance()
    {
        if(self::$instance == false) {

            fileLoader::load('toolkit/compositeToolkit');
            self::$instance = new systemToolkit();
            self::$instance->toolkit = new compositeToolkit();
        }
        return self::$instance;
    }

    public function setToolkit(iToolkit $toolkit)
    {
        $this->toolkit = $toolkit;
    }

    public function addToolkit(iToolkit $toolkit)
    {
        $this->toolkit->addToolkit($toolkit);
    }

    public function getToolkit()
    {
        return $this->toolkit;
    }

    public function __call($methodName, $args)
    {
        $toolkit = $this->toolkit->getToolkit($methodName);
        if ($toolkit == false) {
            throw new mzzRuntimeException("Can't find tool '" . $methodName . "' in toolkit");
        }

        return call_user_func_array(array($toolkit, $methodName), $args);
    }
}
?>