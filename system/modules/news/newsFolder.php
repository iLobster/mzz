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
 * newsFolder: newsFolder
 *
 * @package modules
 * @subpackage news
 * @version 0.1.2
 */

class newsFolder extends entity
{
    protected $module = 'news';

    public function getJip()
    {
        return parent::getJip(1, $this->getTreePath());
        //return parent::__call('getJip', array(1, $this->getTreePath()));
    }
}

?>