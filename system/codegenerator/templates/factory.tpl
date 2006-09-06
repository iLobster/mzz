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
 * {{$factory_data.factory_name}}: фабрика дл€ получени€ контроллеров {{$factory_data.module}}
 *
 * @package modules
 * @subpackage {{$factory_data.module}}
 * @version 0.1
 */


class {{$factory_data.factory_name}} extends simpleFactory
{
    /**
     * »м€ модул€
     *
     * @var string
     */
    protected $name = "{{$factory_data.module}}";
}


?>