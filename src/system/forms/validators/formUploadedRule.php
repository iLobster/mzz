<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * formUploadedRule: валидатор загружаемых файлов
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formUploadedRule extends formAbstractRule
{
    public function notExists()
    {
        $this->validation = false;
    }

    protected function _validate($value, $name = null)
    {
        if (isset($_FILES[$name])) {
            $uploaded = is_uploaded_file($_FILES[$name]['tmp_name']);
            if ($uploaded) {
                return true;
            }

            $error = $_FILES[$name]['error'];
            if (is_array($this->params) && isset($this->params[$error])) {
                $this->message = $this->params[$error];
            }

            /*
            switch ($error) {
                case UPLOAD_ERR_INI_SIZE:
                    $this->message = 'Размер принятого файла превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini';
                    break;

                case UPLOAD_ERR_PARTIAL:
                    $this->message = 'Загружаемый файл был получен только частично';
                    break;
            }
            */
        }

        return false;
    }
}

?>