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
 * adminModule
 *
 * @package modules
 * @subpackage admin
 * @version 0.0.1
 */
class adminModule extends simpleModule
{
    protected $icon = 'sprite:admin/admin/admin';

    protected $classes = array(
        'admin',
        'adminGenerator');

    protected $roles = array(
        'moderator',
        'user');

    public function isSystem()
    {
        return true;
    }
}

?>