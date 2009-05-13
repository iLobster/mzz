<?php

class formAdvancedTextField extends formElement
{
    public function __construct()
    {
        $this->setAttribute('type', 'text');
        $this->setAttribute('value', '');
    }

    public function render($attributes = array(), $value = null)
    {
        return $this->renderTag('input', $attributes);
    }
}

?>