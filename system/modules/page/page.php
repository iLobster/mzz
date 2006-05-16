<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * page: page
 *
 * @package page
 * @version 0.1.2
 */

class page extends simple
{
    /**
     * Получение объекта JIP
     *
     * @return jip
     */
    public function getJip()
    {
        return parent::getJip('page', 'page', $this->getName(), 'page');
    }
}

?>