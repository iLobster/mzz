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
 * formSelectField: выпадающий список
 *
 * @package system
 * @subpackage forms
 * @version 0.2
 */
class formSelectField extends formElement
{
    /**
     * Текущий выбранный элемент
     *
     * @var array
     */
    protected $selected;

    /**
     * Конструктор
     *
     */
    public function __construct()
    {
        $this->setAttribute('multiple', false);
        $this->setAttribute('selected_style', 'font-weight: bold;');
        $this->setAttribute('options', array());
        $this->addOptions(array('options', 'emptyFirst', 'freeze', 'one_item_freeze', 'keyMethod', 'valueMethod', 'selected_style'));
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
        $attributes['options'] = $this->parseI18nOptions($attributes['options']);
        $this->addFirstEmptyOption($attributes);

        if (sizeof($attributes['options']) < 2 && isset($attributes['one_item_freeze']) && $attributes['one_item_freeze']) {
            $attributes['freeze'] = true;
        }

        if (!empty($attributes['multiple']) && substr($attributes['name'], -2) !== '[]') {
            $attributes['name'] .= '[]';
        }
        $value = $this->escapeOnce($this->getElementValue($attributes, false, !empty($attributes['multiple'])));

        $this->setAttribute('keyMethod', isset($attributes['keyMethod']) ? $attributes['keyMethod'] : null);
        $this->setAttribute('valueMethod', isset($attributes['valueMethod']) ? $attributes['valueMethod'] : null);

        // собираем опции
        $options = "\n" . implode("\n", $this->getOptionsForSelect($value, $attributes['options'])) . "\n";

        if ($this->isFreeze($attributes)) {
            reset($attributes['options']);
            // hide current value
            $key = key($attributes['options']);
            $option = current($attributes['options']);
            if (is_object($option)) {
                list($key, $option) = $this->getValuesFromObject(array_shift($attributes['options']), $attributes);
            }
            $value = is_array($this->selected) ? $this->selected[0] : $key;
            $params = array('name' => $attributes['name'], 'value' => $value, 'type' => 'hidden');
            $select = $this->renderTag('input', $params);
            return $select . (is_array($this->selected) ? $this->selected[1] : $option);
        } else {
            $attributes['content'] = $options;
            return $this->renderTag('select', $attributes);
        }

    }

    /**
     * Добавляет первую пустую опцию с произвольным текстом (по умолчанию &nbsp;)
     *
     * @param array $attributes
     */
    protected function addFirstEmptyOption(&$attributes)
    {
        $first = isset($attributes['emptyFirst']) && $attributes['emptyFirst'] !== 0 && $attributes['emptyFirst'] !== false;
        if ($first) {
            $firstText = '&nbsp;';
            if (!is_bool($attributes['emptyFirst']) && $attributes['emptyFirst'] !== 1) {
                $firstText = $this->escapeOnce($attributes['emptyFirst']);
            }
            $attributes['options'] = array('' => $firstText) + $attributes['options'];
        }
    }

    /**
     * Возвращает массив option-тегов на основе массива переданных значений
     *
     * @param string $value значение
     * @param array $optionsValues опции
     * @return array
     */
    protected function getOptionsForSelect($value, $optionsValues)
    {
        $selectAttributes = $this->attributes;
        $this->attributes = array();
        $options = array();
        foreach ($optionsValues as $key => $option) {
            if (is_object($option)) {
                list($key, $option) = $this->getValuesFromObject($option, $selectAttributes);
            }

            if (is_array($option)) {
                $options[] = $this->renderTag('optgroup', array('content' => implode("\n", $this->getOptionsForSelect($value, $option)), 'label' => $this->escapeOnce($key)));
            } else {
                $attributes = array('value' => $this->escapeOnce($key));
                if ((is_array($value) && in_array((string)$key, $value)) || (string)$key == (string)$value) {
                    $attributes['selected'] = 'selected';
                    $this->selected = array($key, $option);
                    if ($style = $selectAttributes['selected_style']) {
                        $attributes['style'] = $style;
                    }
                }

                $attributes['content'] = $this->escapeOnce($option);
                $options[] = $this->renderTag('option', $attributes);
            }
        }

        $this->attributes = $selectAttributes;
        return $options;
    }



    /**
     * Ищет перевод для i18n-строк в опциях
     *
     * @param array $options
     * @return array
     */
    protected function parseI18nOptions($options)
    {
        if (is_string($options) && substr($options, 0, 8) == 'options ') {
            $options_string = substr($options, 8);

            $options = array();

            foreach (explode('|', $options_string) as $val) {
                if (!strpos($val, ':')) {
                    $val = ':' . $val;
                }
                list($key, $value) = explode(':', $val, 2);
                $value = trim($value);
                if (i18n::isName($value)) {
                    // all translates must be saved in simple/i18n
                    $value = i18n::getMessage(substr($value, 2), 'simple');
                }
                if ($key === '') {
                    $options[] = $value;
                } else {
                    $options[$key] = $value;
                }
            }
        }

        return $options;
    }
}

?>
