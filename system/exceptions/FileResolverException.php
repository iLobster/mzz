<?php

class FileResolverException extends mzzException
{

    public function __construct($message, $code = 0)
    {
        $this->setName("File Resolver Exception");
        parent::__construct($message, $code);
    }

}

?>