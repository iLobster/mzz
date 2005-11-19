<?php

class fileResolver
{
    private $patterns = array();
    public function __construct($pattern)
    {
        $this->addPattern($pattern);
    }
    public function addPattern($pattern)
    {
        $this->patterns[] = $pattern;
    }
    public function resolve($request)
    {
        foreach ($this->patterns as $filename) {
            $filename = str_replace('*', $request, $filename);
            //echo $filename . '<br>';
            if (is_file($filename)) {
                return $filename;
            }
        }
        return null;
    }
}

?>