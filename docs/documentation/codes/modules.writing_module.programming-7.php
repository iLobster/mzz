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
            $toolkit = systemToolkit::getInstance();
            $request = $toolkit->getRequest();
            $ownerId = $request->get('owner', 'string', SC_PATH);
            $userMapper = $toolkit->getMapper('user', 'user', 'user');
            $owner = $userMapper->searchById($ownerId);
            
            $comment = $this->create();
            $comment->setParentId($parent_id);
            $this->save($comment, $owner);
        }

        return $comment->getObjId();
    }
}

?>