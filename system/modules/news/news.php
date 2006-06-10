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
     * ��������� ������� JIP
     *
     * @return jip
     */
    public function getJip()
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();
        
        return parent::getJipView($request->getSection(), 'news', $this->getId(), 'news');
    }
}

?>