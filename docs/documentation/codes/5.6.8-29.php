<?php

class commentsFolderMapper extends simpleMapper
{
    [...]
        
    /**
     * �������� ����� ������ � ���������� �� ������ id
     *
     * @param string $id
     * @return void
     */
    public function remove($id)
    {
        $toolkit = systemToolkit::getInstance();

        $commentsMapper = $toolkit->getMapper('comments', 'comments', 'comments');

        foreach ($commentsMapper->searchAllByField('folder_id', $id) as $comment) {
            $commentsMapper->delete($comment->getId());
        }

        $this->delete($id);
    }
    
    [...]
}

?> 