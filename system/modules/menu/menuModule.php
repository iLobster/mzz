<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * menuModule
 *
 * @package modules
 * @subpackage menu
 * @version 0.0.1
 */
class menuModule extends simpleModule
{
    protected $classes = array(
        'menu',
        'menuFolder',
        'menuItem');

    public function getRoutes()
    {
        return array(
            array(),
            array(
                'menuMoveAction' => new requestRoute('menu/:id/:target/move', array(
                    'module' => 'menu',
                    'action' => 'move'), array(
                    'id' => '\d+',
                    'target' => '(?:up|down|\d+)'))));
    }
}
?>