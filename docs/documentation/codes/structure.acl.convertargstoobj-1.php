<?php

class newsMapper extends simpleMapper
{
    [...]

    public function convertArgsToObj($args)
    {
        $news = $this->searchOneByField('id', $args['id']);

        if ($news) {
            return $news;
        }

        throw new mzzDONotFoundException();
    }
}

?>