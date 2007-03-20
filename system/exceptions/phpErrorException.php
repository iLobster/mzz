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

if (!defined("E_RECOVERABLE_ERROR")) {
    define("E_RECOVERABLE_ERROR", 1<<12);
}
/**
 * phpErrorException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1.1
*/
class phpErrorException extends mzzException
{
    /**
     * Конструктор
     *
     * @param integer $errno номер ошибки
     * @param string $errstr текст ошибки
     * @param string $errfile имя файла, в котором обнаружена ошибка
     * @param integer $errline номер строки, в которой обнаружена ошибка
     */
    public function __construct($errno, $errstr, $errfile, $errline)
    {
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
            E_STRICT          => "Runtime Notice",
            E_RECOVERABLE_ERROR => "Recoverable Error"
        );

        $etype = (isset($errortype[$errno])) ? $errortype[$errno] : 'Unknown';
        $message = $etype. ' in file <b>' . $errfile . ':' . $errline . '</b>: ' . $errstr;
        parent::__construct($message);
        $this->setName('PHP Error Exception');
    }
}

?>