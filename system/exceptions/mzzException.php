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
     * Имя исключения
     *
     * @var string
     */
    private $name;

    /**
     * Строка, на которой брошено исключение
     *
     * @var string
     */
    protected $line;

    /**
     * Файл, в котором брошено исключение
     *
     * @var string
     */
    protected $file;

    /**
     * Trace от предыдущего исключения
     *
     * @var array
     */
    protected $prev_trace;

    /**
     * Конструктор
     *
     * @param string $message сообщение исключения
     * @param integer $code код исключения
     * @param string $line строка исключения
     * @param string $file файл исключения
     * @param array $prev_trace trace от предыдущего исключения
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
     * Устанавливает имя исключения
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Возвращает имя исключения
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Возвращает trace от предыдущего исключения
     *
     * @return array|null
     */
    public function getPrevTrace()
    {
        return $this->prev_trace;
    }

    /**
     * Конвертирует параметр $arg в строку
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