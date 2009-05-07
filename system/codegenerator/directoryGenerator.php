<?php

fileLoader::load('codegenerator/exceptions');

class directoryGenerator
{
    private $directory;
    private $default_mode = 0755;

    private $scenario = array();

    public function __construct($name, $mode = null)
    {
        $this->directory = rtrim($name, '\\/');

        if (!is_null($mode)) {
            $this->default_mode = $mode;
        }
    }

    public function create($name, $mode = null)
    {
        $this->validateUpThanRoot($name);

        $name = $this->sub($name);

        $this->validateIsWriteable($name);

        $this->scenario[] = array(
            'type' => 'create',
            'name' => $name,
            'mode' => is_null($mode) ? $this->default_mode : $mode);
    }

    public function rename($old, $new)
    {
        $this->scenario[] = array(
            'type' => 'rename',
            'old' => $this->sub($old),
            'new' => $this->sub($new));
    }

    public function delete($name, $recursive = false)
    {
        if (!$recursive) {
            $this->validateIsEmpty($name);
        }

        $this->scenario[] = array(
            'type' => 'delete',
            'name' => $this->sub($name),
            'recursive' => $recursive);
    }

    private function sub($directory)
    {
        return $this->directory . DIRECTORY_SEPARATOR . $directory;
    }

    private function validateIsEmpty($path)
    {
        if (sizeof(glob($this->sub($path) . '/*'))) {
            throw new directoryGeneratorNotEmptyException($path);
        }
    }

    private function validateIsWriteable($path)
    {
        while ($path = substr($path, 0, strrpos($path, '/'))) {
            if (is_dir($path)) {
                if (!is_writable($path)) {
                    throw new directoryGeneratorNoAccessException($path);
                }

                break;
            }
        }
    }

    private function validateUpThanRoot($name)
    {
        if (strpos($name, '..') !== false) {
            throw new directoryGeneratorException('Directory name can\'t contain ".."');
        }
    }

    public function run()
    {
        $umask = umask(0);

        foreach ($this->scenario as $action) {
            $this->{'run_' . $action['type']}($action);
        }

        $this->scenario = array();

        umask($umask);
    }

    private function run_create($data)
    {
        mkdir($data['name'], $data['mode'], true);
    }

    private function run_rename($data)
    {
        rename($data['old'], $data['new']);
    }

    private function run_delete($data)
    {
        if ($data['recursive']) {
            return $this->delete_recursive($data['name']);
        }

        rmdir($data['name']);
    }

    private function delete_recursive($dir)
    {
        foreach (glob($dir . '/*') as $nested) {
            $this->delete_recursive($nested);
        }

        rmdir($dir);
    }
}

?>