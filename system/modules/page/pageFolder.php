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
 * pageFolder: класс для работы c данными
 *
 * @package modules
 * @subpackage page
 * @version 0.1.1
 */
class pageFolder extends entity
{
    public function getJip()
    {
        return parent::__call('getJip', array(1, $this->getTreePath()));
    }
}

?>