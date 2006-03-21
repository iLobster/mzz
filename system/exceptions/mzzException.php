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
 * mzzException
 *
 * @package system
 * @version 0.1
*/
class mzzException extends Exception
{
    /**
     * ��� ����������
     *
     * @var string
     */
    private $name;

    /**
     * ������, �� ������� ������� ����������
     *
     * @var string
     */
    protected $line;

    /**
     * ����, � ������� ������� ����������
     *
     * @var string
     */
    protected $file;

    /**
     * �����������
     *
     * @param string $message ��������� ����������
     * @param integer $code ��� ����������
     * @param string $line ������ ����������
     * @param string $file ���� ����������
     */
    public function __construct($message, $code = 0, $line = false, $file = false)
    {
        parent::__construct($message, (int)$code);
        $this->setName('System Exception');

        if ($line) {
            $this->line = $line;
        }
        if ($file) {
            $this->file = $file;
        }
    }

    /**
     * ������������� ��� ����������
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * ���������� ��� ����������
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * ������ ����� ���������� �� ���������� � ���� HTML.
     * ���� DEBUG_MODE = false, �� ����� ��������� ���������� ����������.
     *
     */
    public function printHtml()
    {

        $html = $this->getHtmlHeader();

        if(DEBUG_MODE) {
            $msg = "Thrown in file " . $this->getFile() . ' (Line: ' . $this->getLine() . ') ';
            $msg .= "with message: <b>";
            if($this->getCode() != 0) {
                $msg .= "[Code: " . $this->getCode() . "] ";
            }
            $msg .= $this->getMessage() . "</b><br />";
            $trace_msg = $msg . '<br /><b>Trace:</b>';
            $padding = 5;
            $traces = $this->getTrace();
            $count = count($traces);
            foreach ($traces as $trace) {
                if(!isset($trace['file'])) {
                    $trace['file'] = 'unknown';
                }
                if(!isset($trace['line'])) {
                    $trace['line'] = 'unknown';
                }
                $padding += 5;
                $count--;
                $trace_msg .= "<div style='padding: 3px; padding-left: " . $padding . "px; font-size: 10px; background-color: #F1F1F1; '>";
                $trace_msg .= $count . '. <b>File:</b> ' . $trace['file'] . ' <i>(Line: ' . $trace['line'] . ')</i>, ';

                $args = '';
                if (!isset($trace['args'])) {
                    $trace['args'] = $trace;
                }
                foreach ($trace['args'] as $arg) {
                    $args .= $this->convertToString($arg) . ', ';
                }
                $args = substr($args, 0, strlen($args) - 2);

                if(isset($trace['class']) && isset($trace['type'])) {
                    $trace_msg .= '<b>In:</b> ' . $trace['class'] . $trace['type'] . $trace['function'] . '(' . $args . ')<br />';
                } else {
                    $trace_msg .= '<b>In:</b> ' . $trace['function'] . '(' . $args . ')<br />';
                }
                $trace_msg .= '</div>';
            }
            $html .= '<b>Debug-mode �������</b>:<br />' . $trace_msg . '<br /><br />';
            $html .= '<b>������������</b><br />';
            $html .= 'SAPI: <b>' . php_sapi_name() . '</b><br />';
            $html .= 'Software: <b>' . (!empty($_SERVER["SERVER_SOFTWARE"]) ? $_SERVER["SERVER_SOFTWARE"] : "unknown") . '</b><br />';
            $html .= 'PHP: <b>' . PHP_VERSION . ' on ' . PHP_OS . '</b><br />';
            $html .= '������ CMS: <b>' . MZZ_VERSION . ' (Rev. ' . MZZ_VERSION_REVISION . ')</b><br />';
        } else {
            $html .= '<b>Debug-mode ��������</b>.';
        }
        $html .= $this->getHtmlFooter();
        echo $html;
        exit;
    }

    /**
     * ���� HTML ����
     *
     * @return string
     */
    protected function getHtmlHeader()
    {
        $header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
             <head>
                <title>Exception "' . $this->getName() . '"</title>
                <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
                <style type="text/css">
                    #error_table { border: 1px solid #D1D8DC; background-color: #FBFBFB; }
                    #error_content { font-family: tahoma, verdana, arial; font-size: 12px; color: #393939; padding: 8px; }
                    #error_header_left { background-color: #C46666; border-top: 1px solid white; padding-right: 10px;
                                         padding-left: 10px; font-family: tahoma, verdana, arial; font-size: 14px;
                                         color: white; font-weight: bold; }
                    #error_header_right { background-color: #C46666; border-top: 1px solid white; padding-right: 10px; }
                </style>
            </head>
            <body bgcolor="#ffffff">
            <table border="0" cellpadding="0" cellspacing="0" width="800" id="error_table">
                <tr>
                    <td width="100%" id="error_header_left">'.$this->getName().'</td>
                    <td align="right" id="error_header_right"><img src="/templates/images/error.gif" width="29" height="36" border="0" alt="" /></td>
                </tr>
                <tr>
                <td colspan="2" id="error_content"><b>������� ��������� ���������� ��-�� ������ ��� ���������� ��������.</b><br /><br />';
        return $header;
    }

    /**
     * ������������ �������� $arg � ������
     *
     * @param mixed $arg
     */
    protected function convertToString($arg)
    {
         switch (true) {
            case is_object($arg):
                $str = 'object \'' . get_class($arg) . '\'';
                break;

            case is_array($arg):
                $str = 'array(' . count($arg) . ')';
                break;

            case is_resource($arg):
                $str = 'resource ' . get_resource_type($arg) . '';
                break;

            case is_string($arg):
                $str = '\'' . $arg . '\'';
                break;

            case is_scalar($arg):
                if($arg === false) {
                    $str = 'false';
                } elseif ($arg === true) {
                    $str = 'true';
                } else {
                    $str = $arg;
                }
                break;

            default:
                $str = '\'' . $arg . '\'';
                break;
        }
        return $str;
    }
    /**
     * ��� HTML ����
     *
     * @return string
     */
    protected function getHtmlFooter()
    {
        $footer = '</tr>
        </table>
        <br />
        </body>
        </html>';
        return $footer;
    }

}

?>