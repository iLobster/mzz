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
 * commentsModule
 *
 * @package modules
 * @subpackage comments
 * @version 0.0.1
 */
class commentsModule extends simpleModule
{
    protected $classes = array(
        'comments',
        'commentsFolder',
    );

    protected $roles = array(
        'moderator',
        'user'
    );
}
?>