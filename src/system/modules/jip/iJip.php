<?php

/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/jip/jip.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: jip.php 3836 2009-10-16 03:12:59Z zerkms $
 */

interface iJip
{
    public function __construct($jip_id, $template = self::DEFAULT_TEMPLATE);
    public function hasItem($action_name);
    public function &getItem($action_name);
    public function addItem($action_name, $options);
    public function getJip();
    public function setLangs($langs);
    public function getLangs();
}
?>