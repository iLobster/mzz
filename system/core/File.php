<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
fileResolver::includer('exceptions', 'FileException');

/**
 * Класс для работы с файлами
 *
 * @package system
 * @version 0.1
 */
class File
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
     * Режим, в котором открыт файл
     *
     * @var integer
     * @access public
     */
    private $mode;

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
	public function __construct($file, $mode = 'r', $use_include_path = false) {

	    // Allowed modes to use
	    $modes = array('r', 'r+', 'w', 'w+', 'a', 'a+', 'x', 'x+');

	    // Add path to file
	    $this->file = $file;
	    $this->path = dirname($this->file);
        $this->mode = $mode;

        // Опускаем опциональные режимы
        $mode = str_replace(array("b", "t"), "", $this->mode);

	    if (in_array($mode, $modes) == false) {
	    	$error = sprintf($this->errors['unknown_mode'], $this->file, $mode);
            throw new FileException($error);
	    }

	    $this->handle = fopen($this->file, $this->mode, $use_include_path);

	    if(!is_resource($this->handle)) {
	       $error = sprintf($this->errors['unknown_error'], $this->file, $mode);
	       throw new FileException($error);
	    }

	}
    /**
     * Бинарно-безопасное чтение файла
     *
     * @param integer $length количество байт
     * @return string
     */
	public function read($length = 1024) {
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
	public function readc() {
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
	public function write($str) {
	    if($this->mode != "r") {
	        return fwrite($this->handle, $str);
	    } else {
	        $error = sprintf($this->errors['cannot_write'], $this->file, $this->mode);
            throw new FileException($error);
	    }
	}

	/**
	 * Устанавливает смещение в файловом указателе
	 *
	 * @access public
	 * @param integer $offset смещение (байт)
	 * @param integer $whence
	 * @return boolean
	 */
	public function seek($offset, $whence = SEEK_SET) {
	    return (bool)fseek($this->handle, $offset, $whence);
	}

	/**
	 * Сообщает текущее смещение чтения/записи файла
	 *
	 * @access public
	 * @return integer
	 */
	public function ftell() {
	    return ftell($this->handle);
	}

	/**
	 * Получение содержимого всего файла. Если $reset равен true, то перед чтением
	 * смещение устанавливается в 0.
	 *
	 * @access public
	 * @param boolean $reset
	 * @return string
	 */
	public function content($reset = true) {
	    if($reset === true) {
	        $this->seek(0);
	    }
	    return $this->read(filesize($this->file));
	}

	/**
	 * Возвращает true, если достигнут конец файла, иначе false.
	 *
	 * @access public
	 * @return boolean
	 */
	public function feof() {
	    return feof($this->handle);
	}

	/**
	 * Сбрасывает курсор у файлового указателя
	 *
	 * @access public
	 * @return boolean
	 */
	public function rewind() {
	    return rewind($this->handle);
	}

	/**
	 * Портируемое рекомендательное запирание файлов
	 *
	 * @param integer $operation действие
	 * @return boolean
	 */
	public function lock($operation) {
	    return flock($this->handle, $operation);
	}

	/**
	 * Закрытие дескриптора файла
	 *
	 */
	public function __destruct() {
	    fclose($this->handle);
	}


}
/***********  EXAMPLE  ************
$f = new file("C:/tes3t.txt","a+");
$f->write('test?');
$f->rewind();
echo $f->read();
unset($f);
***********************************/
?>
