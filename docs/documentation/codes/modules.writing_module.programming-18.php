<?php

class commentsMapper extends simpleMapper
{
    [...]
    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return object
     */
    public function convertArgsToId($args)
    {
        $comment = $this->searchOneByField('id', $args['id']);
        return $comment->getObjId();
    }
}

?>