<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * errorPagesAction
 *
 * @package modules
 * @subpackage errorPages
 * @version 0.0.1
 */
class errorPagesAction extends simpleAction
{
	/**
     * Run action
     *
     * @return string
     */
    public function run(simpleAction $forAction)
    {
        $controller = $this->getController();
        return $controller->run($forAction);
    }
}
?>