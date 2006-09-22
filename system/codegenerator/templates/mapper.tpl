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
 * {{$mapper_data.mapper_name}}: ������
 *
 * @package modules
 * @subpackage {{$mapper_data.module}}
 * @version 0.1
 */

fileLoader::load('{{$mapper_data.module}}/{{$mapper_data.doname}}');

class {{$mapper_data.mapper_name}} extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = '{{$mapper_data.module}}';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = '{{$mapper_data.doname}}';

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