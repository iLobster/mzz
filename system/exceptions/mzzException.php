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
     * Конструктор
     *
     * @param string $message сообщение исключения
     * @param integer $code код исключения
     * @param string $line строка исключения
     * @param string $file файл исключения
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
     * Конвертирует параметр $arg в строку
     *
     * @param mixed $arg
     */
    public function convertToString($arg)
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
                if ($arg === false) {
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

}

?>