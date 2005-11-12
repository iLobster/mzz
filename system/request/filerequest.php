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

/**
 * HttpFileRequest: class for suitable access to uploaded files. Contains all information
 * about uploaded files
 *
 * @version 0.2
 * @access public
 */
class HttpFileRequest {

    /**
     * Contains information about uploaded files
     *
     * @access private
     * @var array
     */
    private $files;

    /**
     * Hold an instance of the class
     *
     * @var object
     * @access private
     */
    private static $instance;

    /**
     * The singleton method
     *
     * @return object
     */
    function getInstance()
    {
        if (!isset( self::$instance ) ) {
            $classname = __CLASS__;
            self::$instance = new $classname;
        }
        return self::$instance;
    }

    /**
     * Private constructor
     *
     * @access private
     */
    private function __construct()
    {
        $this->files = $_FILES;
    }

    /**
     * Return quantity of uploaded files
     *
     * @return integer
     */
    public function total()
    {
        return count($this->files);
    }

    /**
     * Return true if there is files, else return false
     *
     * @return boolean
     */
    public function hasFiles()
    {
        return !empty($this->files);
    }

    /**
     * Return true if there is file with name $name, else return false
     *
     * @param string $name
     * @return bolean
     */
    public function hasFile($name)
    {
        return isset($this->files[$name]);
    }

    /**
     * Return all indexes of files-array
     *
     * @return array|false
     */
    public function getFileNames()
    {
        if($this->hasFiles()) {
            return array_keys($this->files);
        }
        else {
            return false;
        }
    }

    /**
     * Return original name of uploaded file
     *
     * @param string $name
     * @return string|false
     */
    public function getFileName($name)
    {
        if($this->hasFile($name)) {
            return $this->files[$name]['name'];
        }
        else {
            return false;
        }
    }

    /**
     * Return type of uploaded file
     *
     * @param string $name
     * @return string|false
     */
    public function getFileType($name)
    {
        if($this->hasFile($name)) {
            return $this->files[$name]['type'];
        }
        else {
            return false;
        }
    }

     /**
     * Return path of uploaded file
     *
     * @param string $name
     * @return string|false
     */
    public function getFilePath($name)
    {
        if($this->hasFile($name)) {
            return $this->files[$name]['tmp_name'];
        }
        else {
            return false;
        }
    }

     /**
     * Return size of uploaded file (bytes)
     *
     * @param string $name
     * @return string|false
     */
    public function getFileSize($name)
    {
        if($this->hasFile($name)) {
            return $this->files[$name]['size'];
        }
        else {
            return false;
        }
    }

     /**
     * Return error number of uploaded file
     *
     * @param string $name
     * @return string|false
     */
    public function getFileNumError($name)
    {
        if($this->hasFile($name)) {
            return ($this->files[$name]['error']);
        }
        else {
            return false;
        }
    }

    /**
     * Return true if uploaded file has error, else return false
     *
     * @param string $name
     * @return bolean
     */
    public function hasError($name)
    {
        if($this->hasFile($name)) {
            return (bool)$this->getFileNumError($name);
        }
        else {
            return false;
        }
    }



    /**
     * Return true if some files has error, else return false
     *
     * @return bolean
     */
    public function hasErrors()
    {
        foreach ($this->files as &$file) {
            if($file['error'] !== UPLOAD_ERR_OK) {
                return true;
            }
        }
        return false;
    }

    /**
     * Return error text of uploaded file
     *
     * @param string $name
     * @return string|false
     */
    public function getFileError($name)
    {
        if($this->hasError($name)) {
            switch($this->getFileNumError($name)) {
                case UPLOAD_ERR_INI_SIZE:
                    $error = "Размер принятого файла превысил максимально допустимый размер";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $error = "Размер загружаемого файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $error = "Загружаемый файл был получен только частично.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $error = "Файл не был загружен.";
                    break;
            }
            return $error;
        }
        return false;

    }

    /**
     * Move uploaded file to some path
     *
     * @param string $name name of uploaded file
     * @param string $file path to save uploaded file
     * @param integer $fileMode permisson of the saved file
     * @param bolean $newDir true if is required create new directory for file
     * @param integer $dirMode permisson of new directory
     * @return bolean
     */
    public function move($name, $file, $fileMode = 0644, $newDir = true, $dirMode = 0777)
    {

        $path = dirname($file);
        echo $path;
        if($this->hasError($name) == false) {

            switch (true) {
            case !file_exists($path):
                if($newDir && !@mkdir($path, $dirMode, true)) {
                    $error = 'Can\'t create directory "%s".';
                    $error = sprintf($error, $path);
                    throw new FileException($error);
                    return false;
                }
                elseif ($newDir === false) {
                    $error = 'Directory "%s" not exists.';
                    $error = sprintf($error, $path);
                    throw new FileException($error);
                    return false;
                }
            case !is_dir($path):
                $error = 'Path "%s" is not directory.';
                $error = sprintf($error, $path);
                throw new FileException($error);
                return false;
            case !is_writable($path):
                $error = 'Path "%s" is not writable.';
                $error = sprintf($error, $path);
                throw new FileException($error);
                return false;
            }

            if(@move_uploaded_file($this->getFilePath($name), $file)) {
                @chmod($file,$fileMode);
                return true;
            }
        }
        return false;
    }
}


/// TESTS ///

$bg = HttpFileRequest::getInstance();

try {
$bg->move('userfile', "c:\\blabla\\test",0644);
}
catch (FileException $e) {
    echo $e;
}

var_dump($bg->hasError('userfile'));
var_dump($bg->hasError('userfile2'));
echo $bg->getFileError('userfile2');
print_r($_FILES);
?>