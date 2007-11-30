<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/tags/tagsFactory.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: tagsFactory.php 1121 2007-11-30 04:31:39Z zerkms $
 */

/**
 * tagsFactory: фабрика для получения контроллеров tags
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */

class tagsFactory extends simpleFactory
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = "tags";
}

?>