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
 * commentsOnlyAuthView
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */


class commentsOnlyAuthView extends simpleView
{
    public function toString()
    {
        if ($this->DAO) {
            return $this->smarty->fetch('comments.onlyAuth.tpl');
        }
        return '';
    }
}

?>