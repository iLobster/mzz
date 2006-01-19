<?php

class compositeToolkit implements iToolkit
{
    private $toolkits = array();

    public function __construct()
    {
        foreach ( func_get_args() as $toolkit )
        {
            $this->addToolkit($toolkit);
        }
    }

    public function addToolkit(IToolkit $toolkit)
    {
        array_unshift($this->toolkits, $toolkit);
    }

    public function getToolkit($toolName)
    {
        foreach ( $this->toolkits as $toolkit )
        {
            if ( $obj = $toolkit->getToolkit($toolName) )
            {
                return $obj;
            }
        }
        return NULL;
    }
    public function __call($name, $params)
    {
        if(substr($name, 0, 3) == "set") {
            return $this->getToolkit($name)->$name($params[0]);
        } else {
            return $this->getToolkit($name)->$name();
        }

    }
}
?>