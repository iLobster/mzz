<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/module.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: module.tpl 4245 2010-06-09 14:12:18Z bobr $
 */

/**
 * errorPagesModule
 *
 * @package modules
 * @subpackage errorPages
 * @version 0.0.1
 */
class errorPagesModule extends simpleModule
{

    protected $classes = array('errorPage');
    protected $roles = array();
    protected $version = '0.0.1';
    protected $icon = null;
    protected $isSystem = true;

    /**
     * Returns array of requirements or empty array if all ok
     *
     * @return array
     */
    public function checkRequirements()
    {
        return array();
    }

}
?>
