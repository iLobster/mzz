<?php

class iniFile
{
    private $filename;
    private $content;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function read()
    {
        if (!$this->content) {
            if (!is_file($this->filename)) {
                throw new mzzIoException($this->filename);
            }

            $this->content = parse_ini_file($this->filename, true);
        }

        return $this->content;
    }

    public function write(Array $array)
    {
        $content = '';
        foreach ($array as $section => $fields) {
            $content .= '[' . $section . "]\r\n";
            foreach ($fields as $key => $value) {
                $content .= $key . ' = "' . $value . "\"\r\n";
            }
            $content .= "\r\n";
        }
        $content = substr($content, 0, -2);
        file_put_contents($this->filename, $content);

        $this->content = $array;

        return $content;
    }
}

?>