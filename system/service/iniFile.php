<?php

//хак для php < 5.3
if (!defined('TC_DOLLAR_CURLY')) {
    define('TC_DOLLAR_CURLY', '$');
}

class iniFile
{
    private $options;
    private $content;

    public function __construct($filename, $process_sections = true, $scan_mode = null)
    {
        $this->options = array('filename' => $filename, 'process_sections' => $process_sections);
        if (is_null($scan_mode) && defined('INI_SCANNER_NORMAL')) {
            $scan_mode = INI_SCANNER_NORMAL;
        }
        $this->options['scan_mode'] = $scan_mode;
    }

    public function read()
    {
        $filename = $this->options['filename'];
        if (!$this->content) {
            if (!is_file($filename)) {
                throw new mzzIoException($filename);
            }
            if (defined('INI_SCANNER_RAW')) {
                $this->content = parse_ini_file($filename, $this->options['process_sections'], $this->options['scan_mode']);
            } else {
                $this->content = parse_ini_file($filename, $this->options['process_sections']);
            }
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
        file_put_contents($this->options['filename'], $content);

        $this->content = $array;

        return $content;
    }
}

?>