<?php

class newsMapper extends simpleMapper
{
    [...]

    public function convertArgsToId($args)
    {
        $news = $this->searchOneByField('id', $args['id']);

        if ($news) {
            return (int)$news->getObjId();
        }

        throw new mzzDONotFoundException();
    }
}

?>