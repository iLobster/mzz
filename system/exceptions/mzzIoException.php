<?php

class mzzIoException extends mzzException
{
    public function __construct($filename)
    {
        $message = 'Файл не найден: <i>' . $filename . '</i>';
        parent::__construct($message);
        $this->setName('IO Exception');
    }
}

?>