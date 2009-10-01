<?php

fileLoader::load('codegenerator/fileTransformer');

class fileFullReplaceTransformer extends fileTransformer
{
    private $replace;

    public function __construct($replace)
    {
        $this->replace = $replace;
    }

    public function transform($data)
    {
        return $this->replace;
    }
}

?>