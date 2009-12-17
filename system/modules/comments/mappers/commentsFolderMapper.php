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

fileLoader::load('comments/models/commentsFolder');

/**
 * commentsFolderMapper: маппер
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */
class commentsFolderMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'commentsFolder';
    protected $table = 'comments_commentsFolder';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array('pk','once')
         ),
        'parent_id' => array(
            'accessor' => 'getParentId',
            'mutator' => 'setParentId',
            'options' => array('once'),
        ),
        'module' => array(
            'accessor' => 'getModule',
            'mutator' => 'setModule',
            'options' => array('once'),
        ),
        'type' => array(
            'accessor' => 'getType',
            'mutator' => 'setType',
            'options' => array('once'),
        ),
        'by_field' => array(
            'accessor' => 'getByField',
            'mutator' => 'setByField',
            'options' => array('once'),
        ),
        'comments_count' => array(
            'accessor' => 'getCommentsCount',
            'mutator' => 'setCommentsCount'
        ),
        'comments' => array(
            'accessor' => 'getComments',
            'mutator' => 'setComments',
            'relation' => 'many',
            'mapper' => 'comments/comments',
            'foreign_key' => 'folder_id',
            'local_key' => 'id'
        )
    );

    public function __construct()
    {
        parent::__construct();
        $this->plugins('jip');
        $this->plugins('identityMap');
    }

    public function searchById($id)
    {
        return $this->searchByKey($id);
    }

    public function searchFolder($objectClass, $parentId)
    {
        $criteria = new criteria;
        $criteria->where('type', $objectClass)->where('parent_id', (int)$parentId);
        return $this->searchOneByCriteria($criteria);
    }

    public function commentAdded(Array $data)
    {
        $commentsMapper = systemToolkit::getInstance()->getMapper('comments', 'comments');

        $comment = $data['commentObject'];
        $commentsFolder = $data['commentFolderObject'];

        $criteria = new criteria($commentsMapper->table());
        $criteria->select(new sqlFunction('COUNT', '*'), 'comments_count');
        $criteria->where('folder_id', $commentsFolder->getId());

        $select = new simpleSelect($criteria);
        $commentsCount = $this->db()->getOne($select->toString());
        $commentsFolder->setCommentsCount($commentsCount);
        $this->save($commentsFolder);
    }

    public function delete(commentsFolder $object)
    {
        $commentsMapper = systemToolkit::getInstance()->getMapper('comments', 'comments');

        foreach ($object->getComments() as $comment) {
            $commentsMapper->delete($comment);
        }

        parent::delete($object);
    }
}

?>