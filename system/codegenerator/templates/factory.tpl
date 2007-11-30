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

/**
 * {{$factory_data.factory_name}}: фабрика для получения контроллеров {{$factory_data.module}}
 *
 * @package modules
 * @subpackage {{$factory_data.module}}
 * @version 0.1
 */

class {{$factory_data.factory_name}} extends simpleFactory
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = "{{$factory_data.module}}";
}

?>