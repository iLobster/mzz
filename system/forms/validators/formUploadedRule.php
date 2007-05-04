<?php

fileLoader::load('forms/validators/formAbstractRule');

class formUploadedRule extends formAbstractRule
{
    public function validate()
    {
        if (isset($_FILES[$this->name])) {
            $uploaded = is_uploaded_file($_FILES[$this->name]['tmp_name']);
            if ($uploaded) {
                return true;
            }

            $error = $_FILES[$this->name]['error'];
            switch ($error) {
                case UPLOAD_ERR_INI_SIZE:
                    $this->errorMsg = 'Размер принятого файла превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini';
                    break;

                case UPLOAD_ERR_PARTIAL:
                    $this->errorMsg = 'Загружаемый файл был получен только частично';
                    break;
            }
        }

        return false;
    }
}

?>