<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/mapper.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: mapper.tpl 4004 2009-11-24 00:10:39Z mz $
 */

fileLoader::load('errorPages/models/errorPage');

/**
 * errorPageMapper
 *
 * @package modules
 * @subpackage errorPages
 * @version 0.0.1
 */
class errorPageMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'errorPage';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'errorPage';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array();
}

?>