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
    public function __construct()
    {
        $this->setAttribute('type', 'hidden');
        $this->setAttribute('value', '');
    }

    public function render($attributes = array(), $value = null)
    {
        $clearValue = (isset($attributes['restore']) && $attributes['restore'] == false);

        if (isset($attributes['name']) && !$clearValue && !self::isFreeze($attributes)) {
            $attributes['value'] = $value;
        }

        return $this->renderTag('input', $attributes);
    }
}

?>