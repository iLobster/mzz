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
 * @version 0.1.4
 */

class page extends simple
{
    /**
     * ��������� ������� JIP
     *
     * @return jip
     */
    public function getJip()
    {
        return parent::getJipView('page', $this->getName(), 'page');
    }


}

?>