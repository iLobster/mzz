<?php
    $validator->add('callback', 'name', '�������� �������� ��������', array('sample_callback', time(), mt_rand(1, 10)));

    function sample_callback($value, $time, $rand)
    {
        echo '������� ��������: ' . $value . '<br />';
        echo '������� �����: ' . date('H:i:s d.m.Y', $time) . '<br />';
        echo '��������� ����� � ��������� �� 1 �� 10: ' . $rand;
        return true;
    }
?>