<?php

fileLoader::load('forms/validators/formAbstractRule');

class newFormValidator
{
    private $data;

    private $rules = array();

    /**
     * @var formArrayDataspace
     */
    private $errors;

    private $submit = 'submit';

    public function __construct($data = null)
    {
        $this->errors = new formArrayDataspace($this);
        $this->data = $data;

        $this->rule('required', $this->submit);
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function rule($type, $name, $message = null, $options = null)
    {
        $this->rules[] = array(
            'name' => $name,
            'validator' => $this->loadValidator($type, $message, $options));
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
        foreach ($this->rules as $rule) {
            if ($this->isError($rule['name'])) {
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

    public function isFieldRequired($name)
    {
        foreach ($this->rules as $rule) {
            if ($rule['name'] == $name && $rule['validator'] instanceof formRequiredRule) {
                return true;
            }
        }

        return false;
    }

    private function setError($name, $message)
    {
        if (!$this->isError($name)) {
            $this->errors[$name] = $message;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function isError($name)
    {
        return isset($this->errors[$name]);
    }

    private function isValid()
    {
        return !sizeof($this->errors);
    }
}

?>