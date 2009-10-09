<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * page: page
 *
 * @package modules
 * @subpackage page
 * @version 0.1.4
 */
class page extends entity implements iACL
{
    public function getFullPath()
    {
        $path = $this->getFolder()->getTreePath() . '/' . $this->getName();
        return substr($path, strpos($path, '/') + 1);
    }

    public function getACL($action)
    {

    }
}

?>