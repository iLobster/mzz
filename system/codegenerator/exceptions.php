<?php

class directoryGeneratorException extends mzzRuntimeException
{
}

class directoryGeneratorNoAccessException extends directoryGeneratorException
{
    public function __construct($directory)
    {
        $message = 'Cannot create directory \'' . $directory . '\'. Permission denied.';
        parent::__construct($message);
        $this->setName('No access directory generator Exception');
    }
}

class directoryGeneratorNotEmptyException extends directoryGeneratorException
{
    public function __construct($directory)
    {
        $message = 'Cannot delete directory \'' . $directory . '\'. Directory not empty.';
        parent::__construct($message);
        $this->setName('No empty directory generator Exception');
    }
}

?>