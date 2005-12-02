<?php

class FileException extends mzzException
{

    public function __construct($message, $code = 0)
    {
        $this->setName("File Exception");
        parent::__construct($message, $code);
    }

}

?>