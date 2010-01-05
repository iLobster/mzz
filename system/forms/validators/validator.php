<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formAbstractFilter');
fileLoader::load('forms/formArrayDataspace');

class validator
{
    protected $data;

    protected $rules = array();

    protected $filters = array();

    protected $filtered = false;

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
        $validator->setFieldName($name);
        $this->rules[] = array(
            'name' => $name,
            'validator' => $validator);
    }

    public function filter($type, $name, $options = null)
    {
        $filter = $this->loadFilter($type, $options);
        $this->filters[] = array(
            'name' => $name,
            'filter' => $filter);
    }

    protected function loadValidator($type, $message = null, $options = null)
    {
        $class = 'form' . ucfirst($type) . 'Rule';
        if (!class_exists($class)) {
            fileLoader::load('forms/validators/' . $class);
        }

        return new $class($message, $options);
    }

    protected function loadFilter($type, $options = null)
    {
        $class = 'form' . ucfirst($type) . 'Filter';
        if (!class_exists($class)) {
            fileLoader::load('forms/validators/' . $class);
        }

        return new $class($options);
    }

    public function validate()
    {
        if (!$this->filtered) {
            $this->runFilters();
        }

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

    public function setError($name, $message)
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

    public function export()
    {
        if (!$this->filtered) {
            $this->runFilters();
        }

        return $this->data;
    }

    protected function runFilters()
    {
        foreach ($this->filters as $filter) {
            if (isset($this->data[$filter['name']])) {
                $this->data[$filter['name']] = $filter['filter']->filter($this->data[$filter['name']]);
            }
        }
        $this->filtered = true;
    }
}

?>