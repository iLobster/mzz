<?php

class DbException extends mzzException
{

    public function __construct($message, $code = 0)
    {
        $this->setName("Database Exception");
        parent::__construct($message, $code);
    }

}

?>