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

fileLoader::load('{{$module->getName()}}/models/{{$name}}');

/**
 * {{$name}}Mapper
 *
 * @package modules
 * @subpackage {{$module->getName()}}
 * @version 0.0.1
 */
class {{$name}}Mapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = '{{$name}}';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = '{{$table}}';

    /**
     * Map
     *
     * @var array
     */
    protected $map = {{$map}};
}

?>