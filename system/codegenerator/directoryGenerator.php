<?php

fileLoader::load('codegenerator/exceptions');

class directoryGenerator
{
    private $directory;
    private $default_mode = 0755;

    private $data = array();

    public function __construct($name, $mode = null)
    {
        $this->directory = $name;

        if (!is_null($mode)) {
            $this->default_mode = $mode;
        }
    }

    public function create($name, $mode = null)
    {
        $name = $this->directory . DIRECTORY_SEPARATOR . $name;

        if (strpos($name, '..')) {
            throw new directoryGeneratorException('Directory name can\'t contain ".."');
        }

        $path = $name;
        while ($path = substr($path, 0, strrpos($path, '/'))) {
            if (is_dir($path)) {
                if (!is_writable($path)) {
                    throw new directoryGeneratorNoAccessException($path);
                }

                break;
            }
        }

        $this->data[] = array(
            'name' => $name,
            'mode' => is_null($mode) ? $this->default_mode : $mode);
    }

    public function run()
    {
        $umask = umask(0);

        foreach ($this->data as $key => $directory) {
            mkdir($directory['name'], $directory['mode'], true);
        }

        $this->data = array();

        umask($umask);
    }
}

?>