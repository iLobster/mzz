<?php

fileLoader::load('simple/simpleCatalogueMapper');

class stubMapper extends simpleMapper
{
    protected $name = 'simple';
    protected $className = 'stubSimple';

    public function convertArgsToId($args)
    {
    }
}

class stubCatalogueMapper extends simpleCatalogueMapper
{
    protected $name = 'simple';
    protected $className = 'catalogue';

    public function convertArgsToId($args)
    {
    }
}

class catalogue extends simpleCatalogue
{

}

?>