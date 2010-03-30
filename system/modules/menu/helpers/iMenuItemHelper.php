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
 * iMenuItemHelper
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */
interface iMenuItemHelper
{
    public function setArguments($item, array $args);
    public function injectItem($validator, $item = null, $view = null, array $args = null);
}

?>