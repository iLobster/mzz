<?php

class testCaseFileResolver extends fileResolver
{
    public function __construct($pattern='')
    {
        parent::__construct('./cases/*.case.php');
    }
    public function foo() {
    }
}

?>