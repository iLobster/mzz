<?php

class formTextField extends formElement
{
    static public function toString($options = array())
    {
        // если параметра 'value' нет, примем значение поля равным ''
        $value = isset($options['value']) ? $options['value'] : '';
        
        // если определён параметр 'name'
        if (isset($options['name'])) {
            // то пробуем определить значение из параметров запроса (в случае, если форма уже была отправлена)
            $options['value'] = self::getValue($options['name'], $value);
        }

        // по изменённому массиву опций генерируем html
        return self::createTag($options);
    }
}

?>