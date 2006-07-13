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
 * mzzException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.3
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
     * Trace �� ����������� ����������
     *
     * @var array
     */
    protected $prev_trace;

    /**
     * �����������
     *
     * @param string $message ��������� ����������
     * @param integer $code ��� ����������
     * @param string $line ������ ����������
     * @param string $file ���� ����������
     * @param array $prev_trace trace �� ����������� ����������
     * @internal
     */
    public function __construct($message, $code = 0, $line = false, $file = false, $prev_trace = null)
    {
        parent::__construct($message, (int)$code);
        $this->setName('System Exception');

        if ($line) {
            $this->line = $line;
        }
        if ($file) {
            $this->file = $file;
        }

        $this->prev_trace = $prev_trace;
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
     * ���������� trace �� ����������� ����������
     *
     * @return array|null
     */
    public function getPrevTrace()
    {
        return $this->prev_trace;
    }

    /**
     * ������������ �������� $arg � ������
     *
     * @param mixed $arg
     */
    public function convertToString($arg)
    {
        ob_start();
        var_dump($arg);
        return ob_get_clean();
    }

}

?>