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
 * formCheckboxField: чекбокс
 *
 * @package system
 * @subpackage forms
 * @version 0.1.2
 */
class formCheckboxField extends formElement
{
    /**
     * Конструктор
     *
     */
    public function __construct()
    {
        $this->setAttribute('label_style', 'cursor: pointer; cursor: hand;');
        $this->setAttribute('label_separator', '&nbsp;');
        $this->setAttribute('separator', "\n");
        $this->setAttribute('type', 'checkbox');
        $this->setAttribute('value', '');
        $this->addOptions(array(
        'values', 'text', 'label', 'nodefault', 'label_style', 'options', 'label_separator', 'separator', 'keyMethod', 'valueMethod'
        ));
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
        return isset($attributes['options']) ? $this->renderMany($attributes, $value) : $this->renderOne($attributes, $value);
    }

    /**
     * Преобразовывает массив опций в HTML-теги
     *
     * @param array $attributes
     * @param string $value
     * @return string
     */
    public function renderOne($attributes = array(), $value = null)
    {
        $values = $this->extractValues($attributes);
        $isNoValue = is_null($value) || $value === "";

        if (!in_array($value, $values)) {
            $value = $values[0];
        }

        $attributes['checked'] = ($value == $values[1]) || ($isNoValue && isset($attributes['checked']) && $attributes['checked'] != false);

        if (isset($attributes['label'])) {
            $attributes['text'] = $attributes['label'];
        }

        $attributes['value'] = $values[1];
        $attributes['idFormat'] = $this->getIdFormat() . '_' . $attributes['value'];
        if (isset($attributes['text'])) {
            $label = $this->createLabel($attributes);
        }

        $attributes = $this->setElementId($attributes, $attributes['value']);

        $hidden = null;
        if (!isset($attributes['nodefault']) || !$attributes['nodefault']) {
            $hidden = $this->createHidden($attributes['name'], $values[0]);
        }

        $checkbox = $this->renderTag('input', $attributes);
        return $hidden . $checkbox . (isset($label) ? $attributes['label_separator'] . $label : '');
    }

    /**
     * Преобразовывает массив опций в HTML-теги
     *
     * @param array $attributes
     * @param string $value
     * @return string
     */
    public function renderMany($attributes = array(), $value = null)
    {
        $inputs = array();
        $attributes['name'] = $this->setMultipleName($attributes['name']);
        $originalAttributes = $attributes;
        $value = $this->escapeOnce($this->getElementValue($attributes, false, true));
        foreach ($attributes['options'] as $key => $option) {
            $attributes = $originalAttributes;
            if (is_object($option)) {
                list($key, $option) = $this->getValuesFromObject($option, $attributes, $key);
            }

            $attributes['checked'] = ($this->checkSelected($key, $value) && (!isset($attributes['checked']) || $attributes['checked'] != false));

            if ($attributes['type'] == 'radio') {
                $attributes['idFormat'] = $this->getIdFormat() . '_' . $key;
            }
            $attributes['value'] = $key;
            $attributes['text'] = $option;
            $attributes = $this->setElementId($attributes, $key);


            if (!empty($option)) {
                $label = $this->createLabel($attributes);
            }

            $inputs[] = $this->renderTag('input', $attributes) . (isset($label) ? $attributes['label_separator'] . $label : '');
        }

        return implode($attributes['separator'], $inputs);
    }

    /**
     * Получает два значения из опции values (первое если невыбранно, второе если выбрано).
     * Устанавливает первое значение в атрибуты
     *
     * @param array $attributes
     * @return array
     */
    protected function extractValues(&$attributes)
    {
        if (isset($attributes['values'])) {
            if (!strpos($attributes['values'], '|')) {
                $attributes['values'] = '0|' . $attributes['values'];
            }
            $values = explode('|', $attributes['values'], 2);
            if (!isset($attributes['value'])) {
                $attributes['value'] = $values[0];
            }
        } else {
            $values = array(0, !empty($attributes['value']) ? $attributes['value'] : 1);
        }

        return $values;
    }

    /**
     * Создает label для элемента
     *
     * @param array $attributes
     * @return string
     */
    protected function createLabel($attributes)
    {
        $inputAttributes = $this->attributes;
        $this->attributes = array('label_style' => $this->attributes['label_style']);
        $text = $attributes['text'];
        $attributes = $this->setElementId($attributes, $attributes['value']);

        $label = $this->renderTag('label', array('for' => $attributes['id'], 'style' => $this->getAttribute('label_style'), 'content' => $text));

        $this->attributes = $inputAttributes;
        return $label;
    }

    /**
     * Создает hidden-поля для элемента, значение которого будет использовано, если
     * элемент не выбран
     *
     * @param array $attributes
     * @return string
     */
    protected function createHidden($name, $value)
    {
        $hiddenAttributes = array('type' => 'hidden', 'name' => $name, 'value' => $value);
        $hiddenAttributes['idFormat'] = $this->getIdFormat() . '_default';
        return $this->renderTag('input', $hiddenAttributes);
    }

    protected function setMultipleName($name)
    {
        return substr($name, -2) == '[]' ? $name : $name . '[]';
    }

    protected function checkSelected($key, $value)
    {
        return in_array((string)$key, (array)$value, true);
    }
}

?>