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
 * commentsMapper: ������
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */

fileLoader::load('comments');

class commentsMapper extends simpleMapper
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
    protected $className = 'comments';

    /**
     * ���������� �������� � �������� $fields ����� �������� � ��
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $fields['time'] = time();
    }

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return object
     */
    public function convertArgsToId($args)
    {
        $comment = $this->searchOneByField('id', $args['id']);
        if ($comment) {
            return $comment->getObjId();
        }

        throw new mzzDONotFoundException();
    }
}

?>