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

fileLoader::load('comments/models/comments');
fileLoader::load('orm/plugins/tree_alPlugin');
fileLoader::load('modules/jip/plugins/jipPlugin');

/**
 * commentsMapper: маппер
 *
 * @package modules
 * @subpackage comments
 * @version 0.1.1
 */
class commentsMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'comments';
    protected $table = 'comments_comments';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'orderBy' => 1,
            'options' => array('pk', 'once'),
        ),
        'folder_id' => array(
            'accessor' => 'getFolder',
            'mutator' => 'setFolder',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'comments/commentsFolder',
            'options' => array('once')
        ),
        'user_id' => array(
            'accessor' => 'getUser',
            'mutator' => 'setUser',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'user/user',
            'options' => array('once')
        ),
        'text' => array(
            'accessor' => 'getText',
            'mutator' => 'setText'
        ),
        'created' => array(
            'accessor' => 'getCreated',
            'mutator' => 'setCreated',
            'options' => array('once')
        )
    );

    public function __construct()
    {
        parent::__construct();
        $this->attach(new tree_alPlugin(array('path_name' => 'id')), 'tree');
        $this->plugins('jip');
    }

    public function searchById($id)
    {
        return $this->searchByKey($id);
    }

    public function searchByFolderAndId(commentsFolder $folder, $id)
    {
        $criteria = new criteria;
        $criteria->where('folder_id', $folder->getId())->where('id', $id);
        return $this->searchOneByCriteria($criteria);
    }

    public function preInsert(array &$data)
    {
        $data['created'] = time();
    }

    public function postInsert(entity $object)
    {
        $folder = $object->getFolder();
        $objectMapper = $folder->getObjectMapper();
        $commentedObject = $folder->getObject();

        $criteria = new criteria($this->table());
        $criteria->select(new sqlFunction('COUNT', '*'), 'comments_count');
        $criteria->where('folder_id', $folder->getId());

        $select = new simpleSelect($criteria);
        $commentsCount = $this->db()->getOne($select->toString());
        $folder->setCommentsCount($commentsCount);

        $commentsFolderMapper = systemToolkit::getInstance()->getMapper('comments', 'commentsFolder');
        $commentsFolderMapper->save($folder);

        $data = array(
            'commentedObject' => $commentedObject,
            'commentObject' => $object,
            'commentFolderObject' => $folder
        );

        /*
        $commentsFolderMapper = systemToolkit::getInstance()->getMapper('comments', 'commentsFolder');
        $commentsFolderMapper->notify('commentAdded', $data);
        */

        $objectMapper->notify('commentAdded', $data);
    }

    /*
    public function postDelete(entity $object)
    {
        $commentsFolder = $object->getFolder();
        $commentsFolder->setCommentsCount($commentsFolder->getCommentsCount() - 1);

        $commentsFolderMapper = systemToolkit::getInstance()->getMapper('comments', 'commentsFolder');
        $commentsFolderMapper->save($commentsFolder);
    }
    */
}

?>