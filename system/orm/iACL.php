<?php

interface iACL
{
    /**
     * Get rights on specified action
     *
     * @param simpleAction $action
     * @return bool|null - if returns null then this function call is ignore
     */
    public function getAcl($action);
}

interface iACLMapper
{
    public function convertArgsToObj(array $args);
}

?>