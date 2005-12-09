<?php

class FileException extends mzzException
{

    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
        $this->setName("File Exception");
    }

}

?>