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
 * formTextField: однострочное поле редактирования
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
 */
class formTextField extends formElement
{
    public function __construct()
    {
        $this->setAttribute('type', 'text');
        $this->setAttribute('value', '');
        $this->addOptions(array('restore', 'autocomplete'));
    }

    public function render($attributes = array(), $value = null)
    {
        $clearValue = (isset($attributes['restore']) && $attributes['restore'] == false);

        if (isset($attributes['name']) && !$clearValue && !self::isFreeze($attributes)) {
            $attributes['value'] = $value;
        }
        $autocomplete = '';
        if (isset($attributes['autocomplete']) && $attributes['autocomplete']) {
            $autocomplete = $this->addAutocomplete($attributes);
        }

        return $this->renderTag('input', $attributes) . $autocomplete;
    }

    /**
     * @todo пока не работает
     *
     * @param unknown_type $attributes
     * @return unknown
     */
    protected function addAutocomplete(&$attributes)
    {
        static $i = 0;
        $view = systemToolkit::getInstance()->getView('smarty');
        $type = substr($attributes['autocomplete'], 0, 1) == '[' ? 'local' : 'ajax';
        $id = isset($attributes['id']) ? $attributes['id'] : '__autocompleter_' . $i++;
        $view->assign('id', $id);
        $view->assign('type', $type);
        $view->assign('data', $attributes['autocomplete']);
        $attributes['id'] = $id;
        return $view->render('forms/autocomplete.tpl');
    }
}

?>