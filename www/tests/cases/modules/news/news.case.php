<?php

fileLoader::load('news/news');

class newsTest extends unitTestCase
{
    public function testAccessorsAndMutators()
    {
        $news = new news();
        $props = array('title', 'text', 'folderId');
        foreach ($props as $prop) {

        }
    }
}

?>