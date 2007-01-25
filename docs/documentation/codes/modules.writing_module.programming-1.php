<?php

class commentsFolderMapper extends simpleMapper
{
    [...]
    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return object
     */
    public function convertArgsToId($args)
    {
        $comment = $this->searchOneByField('parent_id', $args['parent_id']);
        return $comment->getObjId();
    }
}

?>