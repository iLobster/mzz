<?php

class testCoreCaseFileResolver extends fileResolver
{
    public function __construct($pattern='')
    {
        parent::__construct('./cases/*.case.php');
    }
}

?>