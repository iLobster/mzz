<?php

fileLoader::load('codegenerator/fileTransformator');

class fileIniTransformator extends fileTransformator
{
    private $action;
    private $params;

    public function __construct($action, $params)
    {
        $this->action = $action;
        $this->params = $params;
    }

    public function transform($data)
    {
        $tmp = tempnam(systemConfig::$pathToTemp, 'itf');

        file_put_contents($tmp, $data);

        $data = parse_ini_file($tmp, true);

        if (is_file($tmp)) {
            unlink($tmp);
        }

        $data = array_merge($data, $this->params);

        $result = '';

        foreach ($data as $section => $section_val) {
            $result .= '[' . $section . "]\r\n";
            foreach ($section_val as $key => $val) {
                $result .= $key . " = " . ((is_numeric($val)) ? $val : '"' . $val . '"') . "\r\n";
            }
        }

        return trim($result);
    }
}

?>