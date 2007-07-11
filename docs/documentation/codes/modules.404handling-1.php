<?php

class newsMapper extends simpleMapper
{
    [...]
    
    public function get404()
    {
        fileLoader::load('news/controllers/news404Controller');
        return new news404Controller();
    }
}

?>