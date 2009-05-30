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

fileLoader::load('comments/commentsFolder');
fileLoader::load('orm/plugins/acl_extPlugin');
fileLoader::load('modules/jip/plugins/jipPlugin');

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
        'comments' => array(
            'accessor' => 'getComments',
            'mutator' => 'setComments',
            'relation' => 'many',
            'mapper' => 'comments/commentsMapper',
            'foreign_key' => 'folder_id',
            'local_key' => 'id'
        )
    );

    public function __construct()
    {
        parent::__construct();
        $this->plugins('acl_ext');
        $this->plugins('jip');
    }

    public function searchById($id)
    {
        return $this->searchByKey($id);
    }

    public function searchFolder($parentType, $parentId)
    {
        $criteria = new criteria;
        $criteria->add('type', $parentType)->add('parent_id', $parentId);
        return $this->searchOneByCriteria($criteria);
    }

    /*
    public function delete(commentsFolder $object)
    {
        $commentsMapper = systemToolkit::getInstance()->getMapper('comments', 'comments');

        foreach ($object->getComments() as $comment) {
            $commentsMapper->delete($comment);
        }

        parent::delete($object);
    }
    */

    public function convertArgsToObj($args)
    {
        //throw new mzzDONotFoundException();
    }
}

?>