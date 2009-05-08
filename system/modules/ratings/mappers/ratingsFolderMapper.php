<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('ratings/ratingsFolder');

/**
 * ratingsFolderMapper: маппер
 *
 * @package modules
 * @subpackage ratings
 * @version 0.3
 */
class ratingsFolderMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'ratingsFolder';
    protected $table = 'ratings_ratingsFolder';

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
        'rating' => array(
            'accessor' => 'getRating',
            'mutator' => 'setRating'
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

    public function convertArgsToObj($args)
    {
    }
}

?>