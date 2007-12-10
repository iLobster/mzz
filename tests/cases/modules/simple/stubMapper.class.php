<?php

fileLoader::load('simple/simpleCatalogueMapper');
fileLoader::load('cases/modules/simple/stubSimple.class');

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