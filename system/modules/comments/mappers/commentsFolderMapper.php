<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

/**
 * commentsFolderMapper: ������
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */

fileLoader::load('comments/commentsFolder');

class commentsFolderMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'comments';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'commentsFolder';

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
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