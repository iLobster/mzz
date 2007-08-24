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

        throw new mzzRuntimeException('���������� ���������� obj_id');
    }
}

?>