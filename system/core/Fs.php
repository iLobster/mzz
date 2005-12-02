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
 * Fs: класс для работы с файлами
 *
 * @package system
 * @version 0.3
 */
class Fs
{
    /**
     * Указатель на открытый ресурс
     *
     * @var resource
     * @access private
     */
    private $handle;

    /**
     * Путь до открытого файла
     *
     * @var string
     * @access public
     */
    private $file;

    /**
     * Путь до папки, в которой находится открытый файл
     *
     * @var string
     * @access public
     */
    private $path;

    /**
     * Режим, в котором был открыт файл, очищенный от опциональных режимах "b" и "t"
     *
     * @var integer
     * @access public
     */
    private $mode;

    /**
     * Режим, в котором открыт файл.
     *
     * @var unknown_type
     */
    private $real_mode;

    /**
     * Описание основных ошибок
     *
     * @var array
     * @access public
     */
    private $errors = array("cannot_write" => "Файл '%s' открыт в режиме 'только чтение'.",
                            "cannot_read" => "Файл '%s' открыт в режиме 'только запись'.",
                            "unknown_mode" => "File: '%s' cann't be open (unknown mode '%s').",
                            "unknown_error" => "File: '%s' cann't be open in '%s' mode (unknown error).");

    /**
     * Открытие файла и сохранение указателя
     *
     * @access public
     * @param string $file путь до файла
     * @param string $mode режим, в котором будет открыт файл
     * @param boolean $use_include_path
     * @return void
     */
    public function __construct($file, $mode = 'r', $use_include_path = false)
    {
        // Allowed modes to use
        $modes = array('r', 'r+', 'w', 'w+', 'a', 'a+', 'x', 'x+');

        // Add path to file
        $this->file = $file;
        $this->path = dirname($this->file);
        $this->real_mode = $mode;

        // Опускаем опциональные режимы
        $this->mode = str_replace(array("b", "t"), "", $mode);

        if (in_array($mode, $modes) == false) {
            $error = sprintf($this->errors['unknown_mode'], $this->file, $mode);
            throw new FileException($error);
        }

        $this->handle = fopen($this->file, $this->real_mode, $use_include_path);

        if(!is_resource($this->handle)) {
           $error = sprintf($this->errors['unknown_error'], $this->file, $this->real_mode);
           throw new FileException($error);
        }
    }

    /**
     * Возвращает указатель на открытый файл
     *
     * @return resource
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * Бинарно-безопасное чтение файла
     *
     * @param integer $length количество байт
     * @return string
     */
    public function read($length = 1024)
    {
        if($this->mode == "r" || strpos($this->mode, "+") !== false) {
            return fread($this->handle, $length);
        } else {
            $error = sprintf($this->errors['cannot_read'], $this->file, $this->mode);
            throw new FileException($error);
        }
    }

    /**
     * Считывание символа из файла
     *
     * @access public
     * @return string
     */
    public function readc()
    {
        if($this->mode == "r" || strpos($this->mode, "+") !== false) {
            return fgetc($this->handle);
        } else {
            $error = sprintf($this->errors['cannot_read'], $this->file, $this->mode);
            throw new FileException($error);
        }
    }

    /**
     * Бинарно-безопасная запись в файл
     *
     * @access public
     * @param string $str строка для записи
     * @return integer|boolean
     */
    public function write($str)
    {
        if(strpos($this->mode, "r") === false || strpos($this->mode, "+") !== false) {
            return fwrite($this->handle, $str);
        } else {
            $error = sprintf($this->errors['cannot_write'], $this->file, $this->mode);
            throw new FileException($error);
        }
    }

    /**
     * Получение содержимого всего файла. Если $reset равен true, то перед чтением
     * смещение устанавливается в 0.
     *
     * @access public
     * @param boolean $reset
     * @return string
     */
    public function content($reset = true)
    {
        if($reset === true) {
            fseek($this->getHandle(), 0);
        }
        return $this->read(filesize($this->file));
    }

    /**
     * Закрытие дескриптора файла при уничтожении объекта
     *
     */
    public function __destruct()
    {
        fclose($this->handle);
    }

}
?>
