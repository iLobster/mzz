<?php

abstract class formAbstractRule
{
    protected $name;
    protected $value;
    protected $errorMsg;

    public function __construct($name, $errorMsg = '')
    {
        $this->name = $name;
        $this->errorMsg = $errorMsg;

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