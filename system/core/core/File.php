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

class File
{
    private $handle;
    private $file;
    private $mode;

    private $errors = array(
                            "not_readable" => "File: '%s' cann't be open in '%s' mode (file not readable).",
                            "not_readable_writable" => "File: '%s' cann't be open in '%s' mode (file not readable/writable).",
                            "not_writable" => "File: '%s' cann't be open in '%s' mode (file not writable).",
                            "file_exists" => "File: '%s' cann't be open in '%s' mode (file exists).",
                            "path_not_writable" => "File: '%s' cann't be open in '%s' mode (path '%s' not writable).",
                            "unknown_mode" => "File: '%s' cann't be open (unknown mode '%s').",
                            "unknown_error" => "File: '%s' cann't be open in '%s' mode (unknown error).");

	public function __construct($file, $mode = 'r', $path = "", $use_include_path = false) {

	    // Allowed modes to use
	    $modes = array('r', 'r+', 'w', 'w+', 'a', 'a+', 'x', 'x+');
	    // Add path to file
	    $this->file = $path.$file;
	    $path = (empty($path))?'./':$path;

        $this->mode = $mode;
        $mode = str_replace(array("b", "t"), "", $mode);

	    if (in_array($mode, $modes) == false) {
	    	$error = sprintf($this->errors['unknown_mode'], $this->file, $mode);
            throw new FileException($error);
	    } elseif($mode == "r" && $this->isReadable() == false) {
	        $error = sprintf($this->errors['not_readable'], $this->file, $mode);
            throw new FileException($error);
	    } elseif (($mode == "r+" || $mode == "w+" || $mode == "a+") && $this->isReadable() == false && $this->isWritable() == false) {
	        $error = sprintf($this->errors['not_readable_writable'], $this->file, $mode);
            throw new FileException($error);
	    } elseif (($mode == "w" || $mode == "a") && $this->isWritable() == false) {
	        $error = sprintf($this->errors['not_writable'], $this->file, $mode);
            throw new FileException($error);
	    } elseif ($mode == "x" || $mode == "x+") {
	        if(file_exists($this->file)) {
	            $error = sprintf($this->errors['file_exists'], $this->file, $mode);
                throw new FileException($error);
	        } elseif (is_writable($path) == false) {
	            $error = sprintf($this->errors['path_not_writable'], $this->file, $mode, $path);
                throw new FileException($error);
	        }
	    }

	    $this->handle = fopen($this->file, $this->mode, $use_include_path);

	    if(!is_resource($this->handle)) {
	       $error = sprintf($this->errors['unknown_error'], $this->file, $mode);
	       throw new FileException($error);
	    }

	}

	public function read($length) {
	    echo fread($this->handle, $length);
	}
	public function write($str) {
	    if(!@fwrite($this->handle, $str)) {
	        return false;
	    }
	    return true;
	}

	public function seek($offset, $whence = "SEEK_SET") {
	    if(!@fseek($this->handle, $offset, $whence)) {
	        return false;
	    }
	    return true;
	}
	public function content() {
	    return fread($this->handle, $this->size());
	}
	public function isReadable() {
	    echo is_readable($this->file);
	    return is_readable($this->file);
	}

	public function isWritable() {

	    return is_writable($this->file);
	}

	public function size() {
	    return filesize($this->file);
	}
	public function isFile() {
	    return is_file($this->file);
	}
	public function feof() {
	    return feof($this->handle);
	}
	public function __destruct() {
	    @fclose($this->handle);
	}

}

?>
