<?php

interface iACL
{
    public function getAcl($action);
}

interface iACLMapper
{
    public function convertArgsToObj(array $args);
}

?>