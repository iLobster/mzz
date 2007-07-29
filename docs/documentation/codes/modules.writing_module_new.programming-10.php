<?php

class messageMapper extends simpleMapper
{
    [...]

    public function convertArgsToObj($args)
    {
        $message = $this->searchByKey($args['id']);
        if ($message) {
            return $message;
        }

        throw new mzzDONotFoundException();
    }
}

?>