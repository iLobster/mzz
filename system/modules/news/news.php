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
 * news: news
 *
 * @package news
 * @version 0.1.1
 */

class news extends simple
{
    /**
     * Получение объекта JIP
     *
     * @return jip
     */
    public function getJip()
    {
        return parent::getJipView('news', $this->getId(), 'news');
    }
}

?>