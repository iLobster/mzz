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
 * @version 0.1.1
 */
class errorDispatcher
{
    protected $exception;

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
        if(error_reporting() && $errno != E_STRICT) {
            throw new phpErrorException($errno, $errstr, $errfile, $errline);
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
        $this->printHtml();
    }

    /**
     * Устанавливает обработчик PHP-ошибок и исключений
     *
     * @param errorDispatcher $dispatcher обработчик
     */
    public function setDispatcher($dispatcher)
    {
        set_error_handler(array($dispatcher, 'errorHandler'));
        set_exception_handler(array($dispatcher, 'exceptionHandler'));
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
     * Вывод исключения в виде HTML
     *
     */
    public function printHtml()
    {

        $html = $this->getHtmlHeader();

        if (DEBUG_MODE) {
            $msg = "<p style='background-color: white; border: 1px solid #E1E1E1; padding: 5px;'>";
            $msg .= $this->exception->getName() . ". Thrown in file " . $this->exception->getFile() . ' (Line: ' . $this->exception->getLine() . ') ';
            $msg .= "with message: <br /><strong>";
            if ($this->exception->getCode() != 0) {
                $msg .= "[Code: " . $this->exception->getCode() . "] ";
            }
            $msg .= $this->exception->getMessage() . "</strong></p>\r\n";

            $trace_msg =  "<a style='cursor: pointer;' onclick=\"javascript: if (document.getElementById('debugTrace').style.display != 'block') document.getElementById('debugTrace').style.display ='block'; else document.getElementById('debugTrace').style.display='none';\"><strong>Показать/скрыть trace</strong></a>\r\n";

            if(($traces = $this->exception->getPrevTrace()) === null) {
                $traces = $this->exception->getTrace();
            }

            $count = count($traces);

            $trace_msg .= "\r\n<p style='color: #424242; display: none;' id='debugTrace'>";
            foreach ($traces as $trace) {
                if (!isset($trace['file'])) {
                    $trace['file'] = 'unknown';
                }
                if (!isset($trace['line'])) {
                    $trace['line'] = 'unknown';
                }
                $count--;
                $trace_msg .= $count . '. ' . $trace['file'] . ':' . $trace['line'] . ', ';
                $args = '';
                if (!isset($trace['args'])) {
                    $trace['args'] = $trace;
                }
                foreach ($trace['args'] as $arg) {
                    $args .= $this->exception->convertToString($arg) . ', ';
                }
                $args = htmlspecialchars(substr($args, 0, strlen($args) - 2));

                if (isset($trace['class']) && isset($trace['type'])) {
                    $trace_msg .= 'In: ' . $trace['class'] . $trace['type'] . $trace['function'] . '(' . $args . ')<br />';
                } else {
                    $trace_msg .= 'In: ' . $trace['function'] . '(' . $args . ')<br />';
                }
                $trace_msg .= "\r\n";
            }
            $trace_msg .= '</p>';

            $html .= $msg . $trace_msg . "\r\n";

            $html .= '<p>SAPI: <strong>' . php_sapi_name() . '</strong>, ';
            $html .= 'Software: <strong>' . (!empty($_SERVER["SERVER_SOFTWARE"]) ? $_SERVER["SERVER_SOFTWARE"] : "unknown") . '</strong>, ';
            $html .= 'PHP: <strong>' . PHP_VERSION . ' on ' . PHP_OS . '</strong>, ';
            $html .= 'Версия mzz: <strong>' . MZZ_VERSION . ' (Rev. ' . MZZ_REVISION . ')</strong>.</p>';
        } else {
            $html .= '<p><strong>Debug-mode выключен.</strong></p>';
        }
        $html .= $this->getHtmlFooter();
        echo $html;
    }

    /**
     * Верх HTML кода
     *
     * @return string
     */
    protected function getHtmlHeader()
    {
        return "\r\n<div style='width: 700px; border: 1px solid #D6D6D6; background-color: #FAFAFA; font-family: tahoma, arial, verdana; font-size: 70%; padding: 10px; line-height: 120%;'>
        <span style='font-weight: bold; color: #AA0000; font-size: 130%;'>Выполнение прервано из-за непредвиденной ситуации.</span>\r\n";
    }

    /**
     * Низ HTML кода
     *
     * @return string
     */
    protected function getHtmlFooter()
    {
        return "\r\n</div>\r\n";
    }

}

?>