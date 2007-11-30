<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('message/messageCategory');

/**
 * messageCategoryMapper: маппер
 *
 * @package modules
 * @subpackage message
 * @version 0.1
 */

class messageCategoryMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'message';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'messageCategory';

    public function convertArgsToObj($args)
    {
        $obj = $this->create();
        $obj->import(array('obj_id' => 1));
        return $obj;
    }
}

?>