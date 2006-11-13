<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

/**
 * commentsFolderListView: вид для метода list модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */


class commentsFolderListView extends simpleView
{
    public function toString()
    {
        return $this->smarty->fetch('comments.list.tpl');
    }
}

?>