<?php

class testFileResolver extends fileResolver
{
    function __construct()
    {
        parent::__construct(systemConfig::$pathToApplication  . '*');
    }
}

?>