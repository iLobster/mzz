<?php

fileLoader::load('codegenerator/exceptions');
fileLoader::load('codegenerator/directoryGenerator');

class fileGenerator
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

    public function create($name, $contents = '', $mode = null)
    {
        if (strpos($name, '/') !== false) {
            $dir = pathinfo($name, PATHINFO_DIRNAME);
            $generator = new directoryGenerator($this->directory);
            $generator->create($dir);
        }

        $this->scenario[] = array(
            'type' => 'create',
            'name' => $this->sub($name),
            'contents' => $contents,
            'generator' => isset($generator) ? $generator : null,
            'mode' => is_null($mode) ? $this->default_mode : $mode);
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
    }

    private function sub($file)
    {
        return $this->directory . DIRECTORY_SEPARATOR . $file;
    }
}

?>