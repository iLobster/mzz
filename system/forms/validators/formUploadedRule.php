<?php

fileLoader::load('forms/validators/formAbstractRule');

class formUploadedRule extends formAbstractRule
{
    public function validate()
    {
        if (isset($_FILES[$this->name])) {
            return is_uploaded_file($_FILES[$this->name]['tmp_name']);
        }

        return false;
    }
}

?>