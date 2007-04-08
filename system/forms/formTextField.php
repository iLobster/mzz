<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

class formTextField extends formElement
{
    static public function toString($options = array())
    {
        $value = isset($options['value']) ? $options['value'] : '';
        $options['value'] = self::getValue($options['name'], $value);

        if (!isset($options['type'])) {
            $options['type'] = 'text';
        }

        return self::createTag($options);
    }
}

?>