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
        $this->setName('Not empty directory generator Exception');
    }
}

class fileGeneratorExistsException extends directoryGeneratorException
{
    public function __construct($file)
    {
        $message = 'Cannot write to file \'' . $file . '\'. File already exists.';
        parent::__construct($message);
        $this->setName('Exists file generator Exception');
    }
}

?>