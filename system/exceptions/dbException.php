<?php

class DbException extends mzzException
{

    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
        $this->setName("Database Exception");
    }

}

?>