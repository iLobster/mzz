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

interface iSessionStorage
{
    function storageOpen();
    function storageClose();
    function storageRead($session_id);
    function storageWrite($session_id, $value);
    function storageDestroy($session_id);
    function storageGc($max_life_time);
}


?>