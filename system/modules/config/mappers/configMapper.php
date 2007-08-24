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
 * configMapper: маппер
 *
 * @package modules
 * @subpackage config
 * @version 0.1
 */

class configMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'config';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'cfg';

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return object
     */
    public function convertArgsToObj($args)
    {
        if (isset($args['section_name']) && isset($args['module_name'])) {
            $toolkit = systemToolkit::getInstance();
            $obj_id = $toolkit->getObjectId('access_' . $args['section_name'] . '_' . $args['module_name']);
            $this->register($obj_id, 'sys', 'access');

            $accessMapper = systemToolkit::getInstance()->getMapper('access', 'access', 'access');
            $obj = $accessMapper->create();
            $obj->import(array('obj_id' => $obj_id));

            return $obj;
        }

        throw new mzzRuntimeException('Невозможно определить obj_id');
    }
}

?>