<?php

class commentsMapper extends simpleMapper
{
    [...]
    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
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