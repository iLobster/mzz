<?php

class mzzIoException extends MzzException
{
    public function __construct($filename)
    {
        $message = '���� �� ������: <i>' . $filename . '</i>';
        parent::__construct($message);
        $this->setName('IO Exception');
    }
}

?>