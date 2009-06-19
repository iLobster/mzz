<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) {{"Y"|date}}
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

{{if $mapper_data.module ne $mapper_data.doname}}
fileLoader::load('{{$mapper_data.module}}/{{$mapper_data.doname}}');
{{else}}
fileLoader::load('{{$mapper_data.module}}');
{{/if}}

/**
 * {{$mapper_data.mapper_name}}: маппер
 *
 * @package modules
 * @subpackage {{$mapper_data.module}}
 * @version 0.1
 */

class {{$mapper_data.mapper_name}} extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = '{{$mapper_data.module}}';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = '{{$mapper_data.doname}}';

    protected $map = array();

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        throw new mzzDONotFoundException();
    }
}

?>