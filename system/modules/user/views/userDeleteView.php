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
 * userDeleteView: גטה הכÿ לועמהא delete למהףכÿ user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */


class userDeleteView extends simpleView
{
    public function toString()
    {
        $url = new url();
        $url->setAction('list'); //location.href = "http://mzz/";
        return '<script type="text/javascript">alert("ûûûûûûû");</script>';
    }
}

?>