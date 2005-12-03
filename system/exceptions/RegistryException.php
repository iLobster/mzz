<?php

class RegistryException extends mzzException
{

    public function __construct($message, $code = 0)
    {
        $this->setName("Registry Exception");
        parent::__construct($message, $code);
    }

}

?>