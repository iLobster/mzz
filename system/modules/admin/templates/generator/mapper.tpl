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

{{if $mapper_data.module ne $mapper_data.name}}
fileLoader::load('{{$mapper_data.module}}/{{$mapper_data.name}}');
{{else}}
fileLoader::load('{{$mapper_data.module}}');
{{/if}}

/**
 * {{$mapper_data.name}}Mapper
 *
 * @package modules
 * @subpackage {{$mapper_data.module}}
 * @version 0.1
 */

class {{$mapper_data.name}}Mapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = '{{$mapper_data.name}}';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = '{{$mapper_data.table}}';
}

?>