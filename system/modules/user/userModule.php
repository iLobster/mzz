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
 * userModule
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class userModule extends simpleModule
{
    protected $classes = array(
        'user',
        'userFolder',
        'userGroup',
        'group',
        'groupFolder',
        'userAuth',
        'userOnline',
        'userRole'
    );

    protected $roles = array(
        'moderator',
        'user');
    
    public function isSystem()
    {
        return true;
    }
}
?>