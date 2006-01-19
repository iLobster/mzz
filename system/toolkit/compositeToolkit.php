<?php
fileLoader::load('toolkit/iToolkit');
class compositeToolkit implements iToolkit
{
    private $toolkits = array();

    public function __construct()
    {
        foreach(func_get_args() as $toolkit) {
            $this->addToolkit($toolkit);
        }
    }

    public function addToolkit(IToolkit $toolkit)
    {
        $this->toolkits[] = $toolkit;
    }

    public function getToolkit($toolName)
    {
        foreach($this->toolkits as $toolkit) {
            if  ($tool = $toolkit->getToolkit($toolName)) {
                return $tool;
            }
        }
        return false;
    }
}
?>