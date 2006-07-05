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
 * errorDispatcher: ����� ��� ������ � PHP-�������� � ������������
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
 */
class errorDispatcher
{
    protected $exception;

    /**
     * �����������
     *
     * @todo ����������� ������������ ������ Dispatcher-�
     *
     */
    public function __construct()
    {
        $this->setDispatcher($this);
    }

    /**
     * ���������� PHP-������.
     *
     * @param integer $errno ����� ������
     * @param string $errstr ����� ������
     * @param string $errfile ��� �����, � ������� ���������� ������
     * @param integer $errline ����� ������, � ������� ���������� ������
     * @throws phpErrorException
     */
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if(error_reporting() && $errno != E_STRICT) {
            throw new phpErrorException($errno, $errstr, $errfile, $errline);
        }
    }

    /**
     * ���������� ����������
     *
     * @param exception $exception
     */
    public function exceptionHandler($exception)
    {
        $this->exception = $exception;
        $this->printHtml();
    }

    /**
     * ������������� ���������� PHP-������ � ����������
     *
     * @param errorDispatcher $dispatcher ����������
     */
    public function setDispatcher($dispatcher)
    {
        set_error_handler(array($dispatcher, 'errorHandler'));
        set_exception_handler(array($dispatcher, 'exceptionHandler'));
    }

    /**
     * ��������������� ����������� ����������� PHP-������ � ����������
     *
     */
    public function restroreDispatcher()
    {
        restore_error_handler();
        restore_exception_handler();
    }

    /**
     * "����������" ����������
     *
     */
    public function printHtml()
    {

        $html = $this->getHtmlHeader();

        if (DEBUG_MODE) {
            $msg = $this->exception->getName() . ". Thrown in file " . $this->exception->getFile() . ' (Line: ' . $this->exception->getLine() . ') ';
            $msg .= "with message: <br /><b>";
            if ($this->exception->getCode() != 0) {
                $msg .= "[Code: " . $this->exception->getCode() . "] ";
            }
            $msg .= $this->exception->getMessage() . "</b><br />";
            $trace_msg = $msg . '<br /><b>Trace:</b>';

            if(($traces = $this->exception->getPrevTrace()) === null) {
                $traces = $this->exception->getTrace();
            }

            $count = count($traces);

            $trace_msg .= '<div style="font-size: 90%;">';
            foreach ($traces as $trace) {
                if (!isset($trace['file'])) {
                    $trace['file'] = 'unknown';
                }
                if (!isset($trace['line'])) {
                    $trace['line'] = 'unknown';
                }
                $count--;
                $trace_msg .= $count . '. File: ' . $trace['file'] . ' <i>(Line: ' . $trace['line'] . ')</i>, ';
                $args = '';
                if (!isset($trace['args'])) {
                    $trace['args'] = $trace;
                }
                foreach ($trace['args'] as $arg) {
                    $args .= $this->exception->convertToString($arg) . ', ';
                }
                $args = substr($args, 0, strlen($args) - 2);

                if (isset($trace['class']) && isset($trace['type'])) {
                    $trace_msg .= 'In: ' . $trace['class'] . $trace['type'] . $trace['function'] . '(' . $args . ')<br />';
                } else {
                    $trace_msg .= 'In: ' . $trace['function'] . '(' . $args . ')<br />';
                }
                $trace_msg .= "\r\n";
            }
            $trace_msg .= '</div>';

            $html .= 'Debug-mode �������:<br />' . $trace_msg . '<br /><br />';

            $html .= '<div style="float: left; margin-right: 15%; font-size: 90%;">';
            $html .= '<strong>SAPI:</strong> ' . php_sapi_name() . '<br />';
            $html .= '<strong>Software:</strong> ' . (!empty($_SERVER["SERVER_SOFTWARE"]) ? $_SERVER["SERVER_SOFTWARE"] : "unknown") . '</div>';
            $html .= '<div style="font-size: 90%;">';
            $html .= '<strong>PHP:</strong> ' . PHP_VERSION . ' on ' . PHP_OS . '<br />';
            $html .= '<strong>������ CMS:</strong> ' . MZZ_VERSION . ' (Rev. ' . MZZ_VERSION_REVISION . ') </div>';
        } else {
            $html .= '<strong>Debug-mode ��������</strong>.';
        }
        $html .= $this->getHtmlFooter();
        echo $html;
    }

    /**
     * ���� HTML ����
     *
     * @return string
     */
    protected function getHtmlHeader()
    {
        $header = "\r\n";
        $header .= '<div style="width: 700px; border: 1px solid #D1D8DC; background-color: #FBFBFB; font-family: tahoma, arial, verdana; font-size: 80%; color: #2E2E2E; padding: 10px;">
<div style="background-color: #C46666; width: 25px; padding-left: 10px; padding-right: 10px; float: left; margin-right: 10px; color: white; font-weight: bold;">500</div>
<div style="font-weight: bold;">������� ��������� ���������� ��-�� ������ ��� ���������� ��������.</div>
<div style="margin-top: 15px; margin-bottom: 5px; font-size: 90%;">';
        $header .= "\r\n";
        return $header;
    }

    /**
     * ��� HTML ����
     *
     * @return string
     */
    protected function getHtmlFooter()
    {
        return "\r\n</div>\r\n";
    }

}

?>