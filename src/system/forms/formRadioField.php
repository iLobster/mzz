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

fileLoader::load('forms/formCheckboxField');

/**
 * formRadioField: радио-кнопка
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formRadioField extends formCheckboxField
{

   public function __construct()
   {
       parent::__construct();
       $this->setAttribute('type', 'radio');
   }

    /**
     * Преобразовывает массив опций в HTML-теги
     *
     * @param array $attributes
     * @param string $value
     * @return string
     */
    public function render($attributes = array(), $value = null)
    {
        $attributes['nodefault'] = true;
        //$value = $this->getElementValue($attributes, null); // what this code is used for?!?!
        return parent::render($attributes, $value);
    }

    protected function setMultipleName($name)
    {
        return substr($name, -2) == '[]' ? substr($name, 0, -2) : $name;
    }

    protected function checkSelected($key, $value)
    {
        return (string)$key == ((string)$value === false ? 0 : $value);
    }
}

?>
