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

/**
 * formHiddenField: hidden
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formHiddenField extends formElement
{
    static public function toString($options = array())
    {
        if (!isset($options['type'])) {
            $options['type'] = 'hidden';
        }

        if (!isset($options['value'])) {
            throw new mzzRuntimeException('Свойство "value" обязательно должно быть заполнено у элемента hidden');
        }

        return self::createTag($options);
    }
}

?>