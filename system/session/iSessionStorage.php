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
    function storageRead($sid);
    function storageWrite($sid, $value);
    function storageDestroy($sid);
    function storageGc($maxLifeTime);
}


?>