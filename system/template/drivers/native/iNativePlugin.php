<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage template
 * @version $Id$
 */

/**
 * Native plugin interface
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
interface iNativePlugin
{
    public function __construct(nativeTemplate $native, view $view);
}
?>