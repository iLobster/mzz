<?php

class sysFileResolver extends fileResolver
{
    function __construct()
    {
        parent::__construct(SYSTEM_DIR . '*');
    }
}

?>