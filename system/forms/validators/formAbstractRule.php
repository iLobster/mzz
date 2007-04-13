<?php

abstract class formAbstractRule
{
    protected $name;
    protected $value;
    protected $errorMsg;
    protected $params;

    public function __construct($name, $errorMsg = '', $params = '')
    {
        $this->name = $name;
        $this->errorMsg = $errorMsg;
        $this->params = $params;

        $request = systemToolkit::getInstance()->getRequest();
        $this->value = $request->get($name, 'string', SC_REQUEST);
    }

    abstract public function validate();

    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

    public function getName()
    {
        return $this->name;
    }
}

?>