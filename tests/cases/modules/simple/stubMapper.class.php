<?php

fileLoader::load('simple/simpleCatalogueMapper');

class stubMapper extends simpleMapper
{
    protected $name = 'simple';
    protected $className = 'stubSimple';

    public function convertArgsToObj($args)
    {
    }
}

class stubCatalogueMapper extends simpleCatalogueMapper
{
    protected $name = 'simple';
    protected $className = 'catalogue';

    public function convertArgsToObj($args)
    {
    }
}

class catalogue extends simpleCatalogue
{

}

?>