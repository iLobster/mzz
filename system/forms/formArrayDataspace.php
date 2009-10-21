<?php

class formArrayDataspace extends arrayDataspace
{
    /**
     * @var formValidator
     */
    private $validator;

    public function __construct($validator, $data = array())
    {
        $this->import($data);
        $this->validator = $validator;
    }

    public function error($field, $value = null)
    {
        if ($this->exists($field)) {
            return is_null($value) ? true : $value;
        }
    }

    public function isValid($value = null)
    {
        if (!($this->count() - 1)) {
            return is_null($value) ? true : $value;
        }

        return false;
    }

    public function required($field, $value = null)
    {
        if ($this->validator->isFieldRequired($field)) {
            return is_null($value) ? true : $value;
        }
    }

    public function message($field)
    {
        if ($this->error($field)) {
            return $this->get($field);
        }
    }

    public function export()
    {
        $tmp = $this->data;
        unset($tmp['_validators']);
        return $tmp;
    }

    public function getCSRFToken()
    {
        return form::getCSRFToken();
    }
}

?>