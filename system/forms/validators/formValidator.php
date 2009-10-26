<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/formArrayDataspace');

class formValidator
{
    private $data;

    private $rules = array();

    private $errors = array();

    private $submit = 'submit';

    public function __construct($data = null)
    {
        $this->data = $data;
        $this->rule('required', $this->submit);
    }

    public function submit($submit)
    {
        foreach ($this->rules as $key => $rule) {
            if ($rule['name'] == $this->submit) {
                unset($this->rules[$key]);
                break;
            }
        }

        $this->submit = $submit;
        $this->rule('required', $this->submit);
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

    private function loadValidator($type, $message, $options)
    {
        $class = 'form' . ucfirst($type) . 'Rule';
        if (!class_exists($class)) {
            fileLoader::load('forms/validators/' . $class);
        }

        return new $class($message, $options);
    }

    public function validate()
    {
        /*
        if (is_null($this->data)) {
            $request = systemToolkit::getInstance()->getRequest();
            $this->data = $request->exportPost() + $request->exportGet();
        }
        */

        if (is_null(systemToolkit::getInstance()->getRequest()->getString($this->submit, SC_REQUEST))) {
            return;
        }

        foreach ($this->rules as $rule) {
            if ($this->isFieldError($rule['name'])) {
                continue;
            }

            $value = $this->getFromRequest($rule['name']);

            if (is_null($value)) {
                $rule['validator']->notExists();
                $value = null;
            }

            if (!$rule['validator']->validate($value)) {
                $this->setError($rule['name'], $rule['validator']->getErrorMsg());
            }
        }

        return $this->isValid();
    }

    private function setError($name, $message)
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

    protected function getFromRequest($name, $type = 'string')
    {
        $funcName = 'get' . ucfirst(strtolower($type));
        $request = systemToolkit::getInstance()->getRequest();
        return $request->$funcName($name, SC_REQUEST);
    }
}

?>