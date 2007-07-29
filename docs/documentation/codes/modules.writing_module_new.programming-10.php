<?php

class messageMapper extends simpleMapper
{
    [...]

    public function convertArgsToObj($args)
    {
        return $this->searchByKey($args['id']);
    }
}

?>