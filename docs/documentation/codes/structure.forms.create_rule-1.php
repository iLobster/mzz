<?php

class formRangeRule extends formAbstractRule
{
    public function validate()
    {
        // проверяем, что введённое значение больше либо равно минимального
        // и меньше либо равно максимального
        return $this->value >= $this->params[0] && $this->value <= $this->params[1];
    }
}

?>