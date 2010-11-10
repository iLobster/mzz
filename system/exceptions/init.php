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
 * @package system
 * @subpackage exceptions
 * @version $Id$
*/

spl_autoload_register('autoloadExceptions');

function autoloadExceptions($exception_name) {
    if (preg_match('/^mzz(.+?)Exception$/', $exception_name)) {
        fileLoader::load('exceptions/' . $exception_name);
    }
}

fileLoader::load('exceptions/phpErrorException');
fileLoader::load('exceptions/errorDispatcher');
?>