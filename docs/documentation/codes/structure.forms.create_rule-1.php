<?php

class formRangeRule extends formAbstractRule
{
    public function validate()
    {
        // ���������, ��� �������� �������� ������ ���� ����� ������������
        // � ������ ���� ����� �������������
        return $this->value >= $this->params[0] && $this->value <= $this->params[1];
    }
}

?>