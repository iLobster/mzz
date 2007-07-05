<?php

class formTextField extends formElement
{
    static public function toString($options = array())
    {
        // ���� ��������� 'value' ���, ������ �������� ���� ������ ''
        $value = isset($options['value']) ? $options['value'] : '';
        
        // ���� �������� �������� 'name'
        if (isset($options['name'])) {
            // �� ������� ���������� �������� �� ���������� ������� (� ������, ���� ����� ��� ���� ����������)
            $options['value'] = self::getValue($options['name'], $value);
        }

        // �� ���������� ������� ����� ���������� html
        return self::createTag($options);
    }
}

?>