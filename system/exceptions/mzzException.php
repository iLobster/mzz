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
 * @version 0.2
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
            $msg = $this->getName() . ". Thrown in file " . $this->getFile() . ' (Line: ' . $this->getLine() . ') ';
            $msg .= "with message: <br /><b>";
            if($this->getCode() != 0) {
                $msg .= "[Code: " . $this->getCode() . "] ";
            }
            $msg .= $this->getMessage() . "</b><br />";
            $trace_msg = $msg . '<br /><b>Trace:</b>';

            $traces = $this->getTrace();
            $count = count($traces);

            $trace_msg .= '<div style="font-size: 90%;">';
            foreach ($traces as $trace) {
                if(!isset($trace['file'])) {
                    $trace['file'] = 'unknown';
                }
                if(!isset($trace['line'])) {
                    $trace['line'] = 'unknown';
                }
                $count--;
                $trace_msg .= $count . '. File: ' . $trace['file'] . ' <i>(Line: ' . $trace['line'] . ')</i>, ';
                $args = '';
                if (!isset($trace['args'])) {
                    $trace['args'] = $trace;
                }
                foreach ($trace['args'] as $arg) {
                    $args .= $this->convertToString($arg) . ', ';
                }
                $args = substr($args, 0, strlen($args) - 2);

                if(isset($trace['class']) && isset($trace['type'])) {
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
        exit;
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
        return "\r\n</div>\r\n";
    }

}

?>