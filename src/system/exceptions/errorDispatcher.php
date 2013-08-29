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

/**
 * errorDispatcher: класс для работы с PHP-ошибками и исключениями
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1.2
 */
class errorDispatcher
{
    protected static $debug_vars = array();
    protected $exception;

    /**
     * Устанавливает обработчик PHP-ошибок и исключений
     *
     * @param errorDispatcher $dispatcher обработчик
     */
    public static function setDispatcher($dispatcher)
    {
        set_error_handler(array($dispatcher, 'errorHandler'));
        set_exception_handler(array($dispatcher, 'exceptionHandler'));
        register_shutdown_function(array($dispatcher, 'shutdownHandler'));
    }
    
    /**
     * Adds variable for debugging. All of them will be outputted below exception information
     * @param mixed $var
     * @param string [$title]  Title will be displayed before output if passed
     * @param string [$rawOutput]  If TRUE, $var will be printed raw (without var_dump)
     */
    public static function debug($var, $title = null, $rawOutput = false)
    {
        self::$debug_vars[] = array('value' => $var, 'title' => $title, 'rawOutput' => $rawOutput);
    }
    
    /**
     * Конструктор
     *
     */
    public function __construct()
    {
    }

    /**
     * Обработчик PHP-ошибок.
     *
     * @param integer $errno номер ошибки
     * @param string $errstr текст ошибки
     * @param string $errfile имя файла, в котором обнаружена ошибка
     * @param integer $errline номер строки, в которой обнаружена ошибка
     * @throws phpErrorException
     */
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if (error_reporting() && $errno != E_STRICT) {
            $this->exceptionHandler(new phpErrorException($errno, $errstr, $errfile, $errline));
        }
    }

    /**
     * Обработчик исключений
     *
     * @param exception $exception
     */
    public function exceptionHandler($exception)
    {
        $this->exception = $exception;
        $toolkit = systemToolkit::getInstance();
        
        // Log exception, if necessary
        if (systemConfig::$logExceptions) {
            $message = ''
                . ($exception->getCode() ? '[Code: ' . $exception->getCode() . '] ' : '')
                . $this->exception->getMessage()
                . '. Thrown in ' . $exception->getFile() . ' (Line: ' . $exception->getLine() . ')'
                . '. URL: ' . $toolkit->getRequest()->getRequestUrl()
                ;
            error_log($message);
        }
        
        $this->outputException();
        $this->outputDebugVars();
        
        exit;
    }
    
    public function shutdownHandler()
    {
        $lastError = error_get_last();
        if (!empty($lastError['type'])) {
            $this->errorHandler($lastError['type'], $lastError['message'], $lastError['file'], $lastError['line']);
        }
        
        $this->outputDebugVars();
    }

    /**
     * Восстанавливает стандартные обработчики PHP-ошибок и исключений
     *
     */
    public function restroreDispatcher()
    {
        restore_error_handler();
        restore_exception_handler();
    }

    /**
     * Вывод исключения
     *
     */
    public function outputException()
    {
        // Kill all buffered data
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        $debug_mode = DEBUG_MODE;
        $exception = $this->exception;
        $system_info = array(
            'sapi' => php_sapi_name(),
            'software' => (!empty($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'unknown'),
            'php' => PHP_VERSION . ' on ' . PHP_OS,
            'mzz' => MZZ_VERSION . ' (Rev. ' . MZZ_REVISION . ')'
        );

        include(dirname(__FILE__) . '/templates/exception.tpl.php');
    }
    
    /**
     * Outputs debug variables
     */
    public function outputDebugVars()
    {
        if (!empty(self::$debug_vars)) {
            $debug_vars = &self::$debug_vars;
            include(dirname(__FILE__) . '/templates/debug.tpl.php');
            
            self::$debug_vars = array(); // to prevent second output
        }
    }

}

?>