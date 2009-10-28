<?php

fileLoader::load('forms/validators/validator');

class formValidator extends validator
{
    protected $submit = 'submit';

    protected $csrf = true;

    public function submit($submit)
    {
        foreach ($this->rules as $key => $rule) {
            if ($rule['name'] == $this->submit) {
                unset($this->rules[$key]);
                break;
            }
        }

        $this->submit = $submit;
    }

    public function validate()
    {
        if (!$this->getValue($this->submit, $submit)) {
            return;
        }

        foreach ($this->rules() as $rule) {
            if ($this->isFieldError($rule['name'])) {
                continue;
            }

            if (!$this->getValue($rule['name'], $value)) {
                $rule['validator']->notExists();
            }

            if (!$rule['validator']->validate($value)) {
                $this->setError($rule['name'], $rule['validator']->getErrorMsg());
            }
        }

        return $this->isValid();
    }

    private function rules()
    {
        if (!$this->csrf) {
            return $this->rules;
        }

        $required = $this->loadValidator('required');
        $required->setData($this->data);
        $csrf = $this->loadValidator('csrf');
        $csrf->setData($this->data);

        return $this->rules + array(
            array(
                'name' => '_csrf_token',
                'validator' => $required),
            array(
                'name' => '_csrf_token',
                'validator' => $csrf));
    }

    private function getValue($name, & $value)
    {
        if (!$this->data) {
            $request = systemToolkit::getInstance()->getRequest();
            $this->data = $request->exportPost() + $request->exportGet();
        }

        $indexName = $this->hasBrackets($name);

        if (!isset($this->data[$name])) {
            $value = null;
            return false;
        }

        $value = $this->data[$name];

        if ($indexName) {
            $value = arrayDataspace::extractFromArray($indexName, $value);
        }

        return true;
    }

    private function hasBrackets(&$name)
    {
        if ($bracket = strpos($name, '[')) {
            $indexName = substr($name, $bracket);
            $name = substr($name, 0, $bracket);

            return $indexName;
        }
    }

    protected function getFromRequest($name, $type = 'string')
    {
        $funcName = 'get' . ucfirst(strtolower($type));
        $request = systemToolkit::getInstance()->getRequest();
        return $request->$funcName($name, SC_REQUEST);
    }
}

?>