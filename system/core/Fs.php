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
 * Fs: ����� ��� ������ � �������
 *
 * @package system
 * @version 0.3
 */
class Fs
{
    /**
     * ��������� �� �������� ������
     *
     * @var resource
     * @access private
     */
    private $handle;

    /**
     * ���� �� ��������� �����
     *
     * @var string
     * @access public
     */
    private $file;

    /**
     * ���� �� �����, � ������� ��������� �������� ����
     *
     * @var string
     * @access public
     */
    private $path;

    /**
     * �����, � ������� ��� ������ ����, ��������� �� ������������ ������� "b" � "t"
     *
     * @var integer
     * @access public
     */
    private $mode;

    /**
     * �����, � ������� ������ ����.
     *
     * @var unknown_type
     */
    private $real_mode;

    /**
     * �������� �������� ������
     *
     * @var array
     * @access public
     */
    private $errors = array("cannot_write" => "���� '%s' ������ � ������ '������ ������'.",
                            "cannot_read" => "���� '%s' ������ � ������ '������ ������'.",
                            "unknown_mode" => "File: '%s' cann't be open (unknown mode '%s').",
                            "unknown_error" => "File: '%s' cann't be open in '%s' mode (unknown error).");

    /**
     * �������� ����� � ���������� ���������
     *
     * @access public
     * @param string $file ���� �� �����
     * @param string $mode �����, � ������� ����� ������ ����
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

        // �������� ������������ ������
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
     * ���������� ��������� �� �������� ����
     *
     * @return resource
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * �������-���������� ������ �����
     *
     * @param integer $length ���������� ����
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
     * ���������� ������� �� �����
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
     * �������-���������� ������ � ����
     *
     * @access public
     * @param string $str ������ ��� ������
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
     * ��������� ����������� ����� �����. ���� $reset ����� true, �� ����� �������
     * �������� ��������������� � 0.
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
     * �������� ����������� ����� ��� ����������� �������
     *
     */
    public function __destruct()
    {
        fclose($this->handle);
    }

}
?>
