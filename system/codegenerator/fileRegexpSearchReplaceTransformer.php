<?php

fileLoader::load('codegenerator/fileTransformer');

class fileRegexpSearchReplaceTransformer extends fileTransformer
{
    private $search;
    private $replace;

    public function __construct($search, $replace)
    {
        $this->search = $search;
        $this->replace = $replace;
    }

    public function transform($data)
    {
        return preg_replace($this->search, $this->replace, $data);
    }
}

?>