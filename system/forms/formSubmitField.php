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
 * formSubmitField: submit
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formSubmitField extends formElement
{
    public function __construct()
    {
        $this->setAttribute('type', 'submit');
        $this->setAttribute('value', '');
        $this->addOptions(array('nodefault'));
    }

    public function render($attributes = array(), $value = null)
    {
        $hidden = '';
        if (empty($attributes['nodefault'])) {
            $hiddenParams = array();
            $hiddenParams['type'] = 'hidden';
            $hiddenParams['value'] = $attributes['value'];
            $hiddenParams['name'] = $attributes['name'];
            $hiddenParams['id'] = $this->generateId($attributes['name'] . '_default', $attributes['idFormat'], $value);
            $hidden = $this->renderTag('input', $hiddenParams);
        }

        return $hidden . $this->renderTag('input', $attributes);
    }
}

?>