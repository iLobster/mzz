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
 * news: news
 *
 * @package modules
 * @subpackage news
 * @version 0.1.1
 */
class news extends entity
{
    public function setCreated($value)
    {
        $datetime = strtotime($value);
        if ($datetime === false) {
            $datetime = explode(' ', $value);
            $time = explode(':', $datetime[0]);
            $date = explode('/', $datetime[1]);
            $datetime = mktime($time[0], $time[1], $time[2], $date[1], $date[0], $date[2]);
        }

        parent::__call('setCreated', array($datetime));
    }
}

?>