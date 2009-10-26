<?php

fileLoader::load('forms/validators/validator');

class formValidator extends validator
{
    protected $submit = 'submit';

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

        foreach ($this->rules as $rule) {
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

    private function getValue($name, & $value)
    {
        if (!$this->data) {
            $value = $this->getFromRequest($name);
            return !is_null($value);
        }

        if (!isset($this->data[$name])) {
            $value = null;
            return false;
        }

        $value = $this->data[$name];
        return true;
    }

    protected function getFromRequest($name, $type = 'string')
    {
        $funcName = 'get' . ucfirst(strtolower($type));
        $request = systemToolkit::getInstance()->getRequest();
        return $request->$funcName($name, SC_REQUEST);
    }
}

?>