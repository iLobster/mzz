<?php
    $validator->add('callback', 'name', 'Введённое значение ошибочно', array('sample_callback', time(), mt_rand(1, 10)));

    function sample_callback($value, $time, $rand)
    {
        echo 'Введено значение: ' . $value . '<br />';
        echo 'Текущее время: ' . date('H:i:s d.m.Y', $time) . '<br />';
        echo 'Случайное число в интервале от 1 до 10: ' . $rand;
        return true;
    }
?>