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
 * accessMapper: ������
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

fileLoader::load('access');

class accessMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'access';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'access';

    public function __construct($section, $alias = 'default')
    {
        parent::__construct($section, $alias);
        $this->table = 'sys_access';
    }

    public function searchByObjId($obj_id)
    {
        return $this->searchAllByField('obj_id', $obj_id);
    }

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return object
     */
    public function convertArgsToId($args)
    {

    }
}

?>