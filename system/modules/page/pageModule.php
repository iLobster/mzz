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
 * pageModule
 *
 * @package modules
 * @subpackage page
 * @version 0.0.1
 */
class pageModule extends simpleModule implements iACL
{
    protected $classes = array(
        'page',
        'pageFolder');

    protected $roles = array(
        'moderator',
        'user');

    protected $icon = 'page.gif';

    public function getAcl($action)
    {
        return;
    }

    public function getRoutes()
    {
        return array(
            array(
                'pageDefault' => new requestRoute('page', array(
                    'module' => 'page',
                    'action' => 'view',
                    'name' => 'main')),
                'pageActions' => new requestRoute('page/:name/:action', array(
                    'module' => 'page',
                    'action' => 'view'), array(
                    'name' => '.+?',
                    'action' => '(?:view|edit|list|create|delete|createFolder|editFolder|moveFolder|deleteFolder|move)'))),
            array());
    }
}

?>