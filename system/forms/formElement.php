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
 * formElement: базовый класс всех элементов формы
 *
 * @package system
 * @subpackage forms
 * @version 0.3
 */
abstract class formElement
{
    /**
     * Атрибуты
     *
     * @var array
     */
    protected $attributes = array('idFormat' => 'form_%s', 'onError' => '');

    /**
     * Опции
     *
     * @var array
     */
    protected $options = array('onError', 'idFormat');

    /**
     * Конструктор
     *
     * @param array $attributes
     */
    public function __construct($attributes = array())
    {
        $this->attributes = array_merge($this->attributes, $attributes);
    }

    /**
     * Устанавливает атрибут элемента "по умолчанию"
     *
     * @param string $name
     * @param string $value
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Возвращает атрибут элемента "по умолчанию"
     *
     * @param string $name
     * @return string
     */
    public function getAttribute($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * Возвращает формат id для элемента по умолчанию
     *
     * @return unknown
     */
    public function getIdFormat()
    {
        return $this->getAttribute('idFormat');
    }

    /**
     * Добавляет опции. Массив содержит только названия атрибутов, которые являются
     * опциями и не должны быть включены в HTML-код
     *
     * @param array $options
     */
    public function addOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Заключительное формирование тега
     *
     * @param string $tag
     * @param array $attributes
     * @return string
     */
    public function renderTag($tag, $attributes = array())
    {
        if (self::parseError($attributes)) {
            $style = explode('=', array_key_exists('onError', $attributes) ? $attributes['onError'] : '', 2);
            if (!empty($style) && sizeof($style) == 2) {
                $style[1] = $style[1][0] == '"' ? trim($style[1], '"') : $style[1];
                $attributes['style'] = isset($attributes['style']) ? $attributes['style'] . '; ' . $style[1] : $style[1];
            } elseif (!empty($style)) {
                $attributes['class'] = isset($attributes['class']) ? $attributes['class'] . ' ' . $style[0] : $style[0];
            }
        }
        if (empty($tag)) {
            return null;
        }

        $attributes = array_merge($this->attributes, $attributes);
        if (isset($attributes['content'])) {
            $content = $attributes['content'];
            unset($attributes['content']);
        }

        if ($this->isFreeze($attributes)) {
            return isset($content) ? $content : $attributes['value'];
        }


        $attributes = $this->setElementId($attributes);
        ksort($attributes);
        $attributes = $this->attributesToHtml($attributes);
        $tag = strtolower($tag);

        if ($tag == 'form') {
            return sprintf('<%s%s>', $tag, $attributes);
        } elseif (!isset($content)) {
            return sprintf('<%s%s%s', $tag, $attributes, form::isXhtml() ? ' />' : ($tag == 'input' ? '>' : sprintf('></%s>', $tag)));
        } else {
            return sprintf('<%s%s>%s</%s>', $tag, $attributes, $content, $tag);
        }
    }

    /**
     * Устанавливает id в атрибуты элемента
     *
     * @param array $attributes
     * @param string $value
     * @return array
     */
    protected function setElementId($attributes, $value = null)
    {
        if (!isset($attributes['id']) && !empty($attributes['name'])) {
            $attributes['id'] = $this->generateId($attributes['name'], $attributes['idFormat'], $value);
        }

        return $attributes;
    }

    /**
     * Генерирует ид соответствующего формата.
     *
     * @param string $name
     * @param string $format
     * @param string $value
     * @return string
     */
    public function generateId($name, $format, $value = null)
    {
        if (!$format) {
            return null;
        }

        if (strpos($name, '[')) {
            $name = str_replace(array('[]', '][', '[', ']'), array((!is_null($value) ? '_' . $value : ''), '_', '_', ''), $name);
        }

        return sprintf($format, $name);
    }

    /**
     * Проверка, является элемент "замороженным" или нет
     *
     * @param array $attributes массив опций
     * @return boolean true, в случае если элемент "заморожен" и false в противном случае
     */
    public function isFreeze(Array $attributes)
    {
        return isset($attributes['freeze']) && $attributes['freeze'];
    }

    /**
     * Возвращает информацию о том, обязательно поле для заполнения или нет
     *
     * @param array $attributes массив опций
     * @return boolean true, в случае, если поле обязательно к заполнению и false - в противном случае
     */
    protected function isRequired(Array $attributes)
    {
        $validator = systemToolkit::getInstance()->getValidator();
        return ($validator instanceof formValidator) ? $validator->isFieldRequired($attributes['name']) : null;
    }

    /**
     * Проверяет, заполнено ли поле с ошибкой
     *
     * @param array $attributes массив опций
     * @return boolean true в случае, если поле введено с ошибками и false в противном случае
     */
    protected function parseError(& $attributes)
    {
        $hasErrors = false;

        $validator = systemToolkit::getInstance()->getValidator();
        if ($validator) {
            $errors = $validator->getErrors();
            if (isset($attributes['name']) && !is_null($errors->get($attributes['name']))) {
                $hasErrors = true;

            }
        }

        return $hasErrors;
    }

    /**
     * Экранирование опций
     *
     * @param string $value
     * @param boolean $js экранирование значений с javascript (необходимо для on* атрибутов)
     * @return string
     */
    protected function escapeOnce($value, $js = false)
    {
        if (is_array($value)) {
            return array_map(array($this, 'escapeOnce'), $value);
        }
        if ($js) {
            return str_replace('"', '&quot;', $value);
        } else {
            return preg_replace('/&amp;([a-z]+|(#\d+)|(#x[\da-f]+));/i', '&$1;', htmlspecialchars($value));
        }
    }

    /**
     * Конвертирование массива опций в строку параметров html тега
     *
     * @param array $attributes массив атрибутов
     * @return string
     */
    public function attributesToHtml($attributes)
    {
        return implode(array_map(array($this, 'attributesToHtmlCallback'), array_keys($attributes), array_values($attributes)));
    }

    /**
     * Callback, конвертирующий пару ключ, значение в HTML-атрибут
     *
     * @param string $key
     * @param string $val
     * @return string
     */
    protected function attributesToHtmlCallback($key, $val)
    {
        if ($val === false || is_null($val) || in_array($key, $this->options) || ($val === '' && $key != 'value')) {
            return null;
        }

        if (in_array($key, array('disabled', 'readonly', 'multiple', 'checked', 'selected'))) {
            if ($val) {
                $val = $key;
            } else {
                return null;
            }
        }

        $val = is_scalar($val) ? $val : '';
        return sprintf(' %s="%s"', $key, $this->escapeOnce($val, substr($key, 0, 2) == 'on'));
    }

    /**
     * Получение значения, введённого в поле формы
     *
     * @param string $name имя поля
     * @param string $default значение по умолчанию, используется в случае, когда значение поля не найдено в суперглобальных массивах $_POST или $_GET
     * @return string
     */
    public function getElementValue($attributes, $default = false, $array = false)
    {
        $attributes = array_merge($this->attributes, $attributes);
        $name = isset($attributes['name']) ? $attributes['name'] : '';
        $default = $default !== false ? $default : (isset($attributes['value']) ? $attributes['value'] : false);

        if (empty($name)) {
            return $default;
        }

        $request = systemToolkit::getInstance()->getRequest();

        if(!$array && $pos = strpos($name, '[]')) {
            $name = $this->replaceArraysFromName($name);
        } elseif ($array && substr($name, -2) == '[]') {
            $name = substr($name, 0, strlen($name) - 2);
        }

        $value = $request->getRaw($name, SC_REQUEST);
        return !is_null($value) ? $value : $default;
    }

    /**
     * Добавляет индексы в пустые "указатели массива" ([])
     *
     * @param unknown_type $name
     * @return unknown
     */
    protected function replaceArraysFromName($name)
    {
        $pos = strpos($name, '[]');
        if (!isset(form::$counts[$name])) {
            form::$counts[$name] = 0;
        } else {
            form::$counts[$name]++;
        }
        $pos += 2;
        return str_replace('[]', '[' . form::$counts[$name] . ']', substr($name, 0, $pos)) . str_replace('[]', '[0]', substr($name, $pos));
    }

    /**
     * Возвращает значения, полученные из объекта вызовом методов, указанных
     * в опциях keyMethod для ключа значения и valueMethod для значения
     *
     * @param simple|object $object
     * @param array $attributes
     * @return array массив из двух элементов: ключ и значение
     */
    protected function getValuesFromObject($object, $attributes, $key = null)
    {
        $value = isset($attributes['valueMethod']) ? $object->$attributes['valueMethod']() : null;
        $key = isset($attributes['keyMethod']) ? $object->$attributes['keyMethod']() : $key;

        return array($key, $value);
    }

    /**
     * Возвращает html-код элемента
     *
     * @param array $attributes
     * @return string
     */
    public function toString($attributes = array())
    {
        $value = $this->escapeOnce($this->getElementValue($attributes));
        // сливаем атрибуты с атрибутами по умолчанию
        $attributes = array_merge($this->attributes, $attributes);
        if (!array_key_exists('name', $attributes)) {
            throw new mzzRuntimeException('Элементу формы обязательно нужно указывать имя');
        }
        return $this->render($attributes, $value);
    }

    /**
     * Абстрактный метод, используется в наследниках для определения алгоритма генерации тегов
     *
     * @param array $attributes
     */
    abstract public function render($attributes = array(), $value = null);

}

?>