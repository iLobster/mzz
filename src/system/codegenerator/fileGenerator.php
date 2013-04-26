<?php

fileLoader::load('codegenerator/exceptions');
fileLoader::load('codegenerator/directoryGenerator');
fileLoader::load('codegenerator/fileTransformer');

class fileGenerator
{
    private $directory;
    private $default_mode = 0664;

    private $scenario = array();

    public function __construct($name, $mode = null)
    {
        $this->directory = rtrim($name, '\\/');

        if (!is_null($mode)) {
            $this->default_mode = $mode;
        }
    }

    public function create($name, $contents = '', $mode = null)
    {
        $mode = is_null($mode) ? $this->default_mode : $mode;

        if (strpos($name, '/') !== false) {
            $dir = pathinfo($name, PATHINFO_DIRNAME);
            if (!is_dir($this->directory . '/' . $dir)) {
                $generator = new directoryGenerator($this->directory, $mode | ($mode & 0444) >> 2);
                $generator->create($dir);
            }
        }

        $name = $this->sub($name);

        if (is_file($name)) {
            throw new fileGeneratorExistsException($name);
        }

        $this->scenario[] = array(
            'type' => 'create',
            'name' => $name,
            'contents' => $contents,
            'generator' => isset($generator) ? $generator : null,
            'mode' => $mode);
    }

    public function rename($old, $new)
    {
        $this->scenario[] = array(
            'type' => 'rename',
            'old' => $this->sub($old),
            'new' => $this->sub($new));
    }

    public function delete($name, array $options = array())
    {
        $name = $this->sub($name);

        if (!is_file($name)) {
            if (!in_array('ignore', $options)) {
                throw new fileGeneratorExistsException($name);
            }
        } elseif (!is_writable($name)) {
            throw new fileGeneratorNotWritableException($name);
        }

        $this->scenario[] = array(
            'type' => 'delete',
            'name' => $name);
    }

    public function edit($name, fileTransformer $transformator)
    {
        $name = $this->sub($name);

        if (!is_writable($name)) {
            throw new fileGeneratorNotWritableException($name);
        }

        $this->scenario[] = array(
            'type' => 'edit',
            'name' => $name,
            'transformator' => $transformator);
    }

    public function run()
    {
        foreach ($this->scenario as $action) {
            $this->{'run_' . $action['type']}($action);
        }

        $this->scenario = array();
    }

    private function run_create($data)
    {
        if ($data['generator']) {
            $data['generator']->run();
        }

        file_put_contents($data['name'], $data['contents']);
        chmod($data['name'], $data['mode']);
    }

    private function run_rename($data)
    {
        rename($data['old'], $data['new']);
    }

    private function run_delete($data)
    {
        if (is_file($data['name'])) {
            unlink($data['name']);
        }
    }

    private function run_edit($data)
    {
        file_put_contents($data['name'], $data['transformator']->transform(file_get_contents($data['name'])));
    }

    private function sub($file)
    {
        return $this->directory . DIRECTORY_SEPARATOR . $file;
    }
}

?>