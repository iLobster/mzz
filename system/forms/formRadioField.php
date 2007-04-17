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

class formRadioField extends formElement
{
    static public function toString($options = array())
    {
        if (isset($options['text'])) {
            $text = $options['text'];
            unset($options['text']);

            $id = 'mzzForms_' . md5(microtime(true));
            $label = self::createTag(array('for' => $id, 'style' => 'cursor: pointer; cursor: hand;', 'content' => $text), 'label');

            $options['id'] = $id;
        }
        $options['type'] = 'radio';
        $value = $options['value'];

        $requestValue = self::getValue($options['name']);

        if ((string)$value === $requestValue) {
            $options['checked'] = true;
        } elseif ($requestValue !== false) {
            unset($options['checked']);
        }

        $checkbox = self::createTag($options);

        return $checkbox . (isset($label) ? $label : '');
    }
}

?>