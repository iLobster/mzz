<?php

class appFileResolver extends fileResolver
{
    function __construct()
    {
        parent::__construct(APPLICATION_DIR . '*');
    }
}

?>