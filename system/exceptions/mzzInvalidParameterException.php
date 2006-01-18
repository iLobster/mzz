<?php

class mzzInvalidParameterException extends mzzException
{

    public function __construct($message, $param, $code = 0)
    {
        $message = $message . ', param: ' . $param . ' [Type: ' .gettype($param) . ']';
        parent::__construct($message, $code);
        $this->setName('Invalid Parameter');
    }

}

?>