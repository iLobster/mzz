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
                    $this->errorMsg = '������ ��������� ����� �������� ����������� ���������� ������, ������� ����� ���������� upload_max_filesize ����������������� ����� php.ini';
                    break;

                case UPLOAD_ERR_PARTIAL:
                    $this->errorMsg = '����������� ���� ��� ������� ������ ��������';
                    break;
            }
        }

        return false;
    }
}

?>