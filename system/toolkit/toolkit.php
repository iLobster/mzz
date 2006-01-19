<?php
fileLoader::load('toolkit/iToolkit');

abstract class toolkit implements iToolkit
{
    private $tools = array();

    public function __construct()
    {
        $selfMethods = get_class_methods('toolkit');
        $childToolkitMethods = get_class_methods($this);
        foreach ( $childToolkitMethods as $value )
        {
            if ( !in_array($value, $selfMethods) )
            {
                $this->tools[] = strtolower($value);
            }
        }
    }

    final public function getToolkit($toolName)
    {
        return in_array(strtolower($toolName), $this->tools) ? $this : false;
    }
}
?>