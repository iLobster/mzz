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
 * @version 0.1.2
 */
abstract class formElement
{
    /**
     * Массив, используемый для индексирования элементов форм, в именах которых используется []
     *
     * @var array
     */
    static protected $counts = array();

    /**
     * Создание тегов
     *
     * @param array $options массив опций
     * @param string $name имя тега
     * @return string|null
     */
    static public function createTag(Array $options = array(), $name = 'input')
    {
        /*
        @todo а нужно ли изменять стили стандартных элементов форм?
        if (!isset($options['onError'])) {
            $options['onError'] = $name == 'span' ? 'style=color: red;' : '';
        }*/

        self::parseError($options);

        if (!$name) {
            return null;
        }
        $content = isset($options['content']) ? $options['content'] : false;
        unset($options['content']);

        if (self::isFreeze($options)) {
            $html = $options['value'];
        } else {
            $html = self::buildTag($options, $name, $content);
        }

        return $html;
    }

    static public function buildTag($options, $name = 'input', $content = false)
    {
        $html = '<' . $name . self::optionsToString($options);
        if ($content !== false) {
            $content = is_scalar($content) ? $content : '';
            $html .= '>' . $content . '</' . $name . '>';
        } else {
            $html .= ($name == 'input' || $name == 'img') ? ' />' : '>';
        }
        return $html;
    }

    /**
     * Проверка, является элемент "замороженным" или нет
     *
     * @param array $options массив опций
     * @return boolean true, в случае если элемент "заморожен" и false в противном случае
     */
    static public function isFreeze(Array $options)
    {
        return isset($options['freeze']) && $options['freeze'];
    }

    /**
     * Возвращает информацию о том, обязательно поле для заполнения или нет
     *
     * @param array $options массив опций
     * @return boolean true, в случае, если поле обязательно к заполнению и false - в противном случае
     */
    static protected function isRequired(Array $options)
    {
        $validator = systemToolkit::getInstance()->getValidator();
        return ($validator instanceof formValidator) ? $validator->isFieldRequired($options['name']) : null;
    }

    /**
     * Проверяет, заполнено ли поле с ошибкой, и если да - тогда обрабатывает опцию onError, в которой содержатся изменённые стили и другие опции html для ошибочного поля
     *
     * @param array $options массив опций
     * @return boolean true в случае, если поле введено с ошибками и false в противном случае
     */
    static protected function parseError(& $options)
    {
        $hasErrors = false;

        $validator = systemToolkit::getInstance()->getValidator();
        if ($validator) {
            $errors = $validator->getErrors();
            if (isset($options['name']) && !is_null($errors->get($options['name']))) {
                $hasErrors = true;

                if (isset($options['onError']) && $options['onError'] != false) {
                    $onError = explode('=', $options['onError']);
                    $cnt = sizeof($onError);
                    for ($i=1; $i < $cnt; $i = $i + 2) {
                        $options[$onError[$i-1]] = trim($onError[$i], '"\'');
                    }

                }
            }
        }
        $options['onError'] = false;

        return $hasErrors;
    }

    /**
     * Конвертирование массива опций в строку параметров html тега
     *
     * @param array $options массив опций
     * @return string
     */
    static public function optionsToString(Array $options = array())
    {
        $html = '';

        foreach (array('disabled', 'readonly', 'multiple', 'checked', 'selected') as $attribute) {
            if (isset($options[$attribute])) {
                if ($options[$attribute]) {
                    $options[$attribute] = $attribute;
                } else {
                    unset($options[$attribute]);
                }
            }
        }
        ksort($options);
        foreach ($options as $key => $value) {
            if (!empty($key) && $value !== false) {
                $value = is_scalar($value) ? $value : '';
                $html .= ' ' . $key . '="' . self::escapeOnce($value, substr($key, 0, 2) == 'on') . '"';
            }
        }
        return $html;
    }

    /**
     * Экранирование опций
     *
     * @param string $value
     * @return string
     */
    static protected function escapeOnce($value, $js = false)
    {
        if ($js) {
            return str_replace('"', '&quot;', $value);
        } else {
            return preg_replace('/&amp;([a-z]+|(#\d+)|(#x[\da-f]+));/i', '&$1;', htmlspecialchars($value));
        }
    }

    /**
     * Получение значение, введённого в поле формы
     *
     * @param string $name имя поля
     * @param string $default значение по умолчанию, используется в случае, когда значение поля не найдено в суперглобальных массивах $_POST или $_GET
     * @return string
     */
    static public function getValue($name, $default = false, $array = false)
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        if(!$array && $pos = strpos($name, '[]')) {
            if (!isset(self::$counts[$name])) {
                self::$counts[$name] = 0;
            } else {
                self::$counts[$name]++;
            }
            $pos += 2;
            $name = str_replace('[]', '[' . self::$counts[$name] . ']', substr($name, 0, $pos)) . str_replace('[]', '[0]', substr($name, $pos));
        } elseif ($array && substr($name, -2) == '[]') {
            $name = substr($name, 0, strlen($name) - 2);
        }
        $value = $request->getRaw($name, SC_REQUEST);
        return !is_null($value) ? $value : $default;
    }

    /**
     * Абстрактный метод, используется в наследниках для определения алгоритма генерации тегов
     *
     * @param array $options
     */
    abstract static public function toString($options = array());
}

?>