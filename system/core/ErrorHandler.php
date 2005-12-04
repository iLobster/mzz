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
 * Общий обработчик ошибок, генерируемых PHP. Для вывода используют шаблон "php_error.tpl".
 *
 * @package system
 * @version 0.2
 * @param integer $errno номер ошибки
 * @param string $errstr текст ошибки
 * @param string $errfile имя файла, в котором обнаружена ошибка
 * @param integer $errline номер строки, в которой обнаружена ошибка
 * @return void|false Возвращает false если тип ошибки E_STRICT
 */
function ErrorHandler($errno, $errstr, $errfile, $errline)
{

    // Типы ошибок
    $errortype = array (
               E_ERROR           => "Error",
               E_WARNING         => "Warning",
               E_PARSE           => "Parsing Error",
               E_NOTICE          => "Notice",
               E_CORE_ERROR      => "Core Error",
               E_CORE_WARNING    => "Core Warning",
               E_COMPILE_ERROR   => "Compile Error",
               E_COMPILE_WARNING => "Compile Warning",
               E_USER_ERROR      => "User Error",
               E_USER_WARNING    => "User Warning",
               E_USER_NOTICE     => "User Notice",
               E_STRICT          => "Runtime Notice"
               );

    // Вывод E_STRICT ошибок отключен.
    if($errno == '2048') {
        return false;
    }

    $registry = Registry::instance();
    $smarty = $registry->getEntry('smarty');
    $params = array('software' => (!empty($_SERVER["SERVER_SOFTWARE"]) ? $_SERVER["SERVER_SOFTWARE"] : "unknown"),
                    'errortype' => $errortype, 'errstr' => $errstr, 'errfile' => $errfile, 'errline' => $errline,
                    'errno' => $errno, 'sapi' => php_sapi_name());

    $smarty->assign($params);
    $smarty->display('php_error.tpl');

}

set_error_handler("ErrorHandler");

?>