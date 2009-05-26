<?php

fileLoader::load('codegenerator/fileTransformer');

class fileSearchReplaceTransformer extends fileTransformer
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
        if (is_null($this->search)) {
            return $this->replace;
        }

        return str_replace($this->search, $this->replace, $data);
    }
}

?>