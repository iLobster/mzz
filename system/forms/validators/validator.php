<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/formArrayDataspace');

class validator
{
    protected $data;

    protected $rules = array();

    protected $errors = array();

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function rule($type, $name, $message = null, $options = null)
    {
        $validator = $this->loadValidator($type, $message, $options);
        $validator->setData($this->data);
        $this->rules[] = array(
            'name' => $name,
            'validator' => $validator);
    }

    protected function loadValidator($type, $message = null, $options = null)
    {
        $class = 'form' . ucfirst($type) . 'Rule';
        if (!class_exists($class)) {
            fileLoader::load('forms/validators/' . $class);
        }

        return new $class($message, $options);
    }

    public function validate()
    {
        foreach ($this->rules as $rule) {
            if ($this->isFieldError($rule['name'])) {
                continue;
            }

            if (!isset($this->data[$rule['name']])) {
                $rule['validator']->notExists();
                $value = null;
            } else {
                $value = $this->data[$rule['name']];
            }

            if (!$rule['validator']->validate($value)) {
                $this->setError($rule['name'], $rule['validator']->getErrorMsg());
            }
        }

        return $this->isValid();
    }

    protected function setError($name, $message)
    {
        if (!$this->isFieldError($name)) {
            $this->errors[$name] = $message;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isFieldRequired($name, $value = null)
    {
        foreach ($this->rules as $rule) {
            if ($rule['name'] == $name && $rule['validator'] instanceof formRequiredRule) {
                return is_null($value) ? true : $value;
            }
        }

        return false;
    }

    public function isFieldError($field, $value = null)
    {
        if (isset($this->errors[$field])) {
            return is_null($value) ? true : $value;
        }

        return false;
    }

    public function getFieldError($field)
    {
        $message = null;
        if ($this->isFieldError($field)) {
            $message = $this->errors[$field];
        }

        return $message;
    }

    public function isValid()
    {
        return !sizeof($this->errors);
    }
}

?>