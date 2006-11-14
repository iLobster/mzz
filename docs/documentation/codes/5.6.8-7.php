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
        $parent_id = isset($args['parent_id']) ? $args['parent_id'] : $args['id'];

        $comment = $this->searchOneByField('parent_id', $parent_id);

        if (is_null($comment)) {
            $comment = $this->create();
            $comment->setParentId($parent_id);
            $this->save($comment);
        }

        return $comment->getObjId();
    }
}

?>