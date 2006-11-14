<?php

class commentsFolderMapper extends simpleMapper
{
    [...]
    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return object
     */
    public function convertArgsToId($args)
    {
        $comment = $this->searchOneByField('parent_id', $args['parent_id']);

        if (is_null($comment)) {
            $comment = $this->create();
            $comment->setParentId($args['parent_id']);
            $this->save($comment);
        }

        return $comment->getObjId();
    }
}

?>