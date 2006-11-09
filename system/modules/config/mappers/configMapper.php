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
 * configMapper: ������
 *
 * @package modules
 * @subpackage config
 * @version 0.1
 */

fileLoader::load('config');

class configMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'config';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'cfg';

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return object
     */
    public function convertArgsToId($args)
    {
        if (isset($args['section_name']) && isset($args['module_name'])) {
            $toolkit = systemToolkit::getInstance();
            $obj_id = $toolkit->getObjectId('access_' . $args['section_name'] . '_' . $args['module_name']);
            $this->register($obj_id, 'sys', 'access');
            return $obj_id;
        }

        throw new mzzRuntimeException('���������� ���������� obj_id');
    }
}

?>