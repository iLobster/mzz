<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage request
 * @version $Id$
*/

fileLoader::load('request/iRoute');

/**
 * requestRoute: правило для маршрутизатора.
 * При совпадении PATH с шаблоном правила производит его декомпозицию.
 *
 * Примеры:
 * <code>
 * new requestRoute(':controller/:id/:action'); // совпадает с news/1/view
 * new requestRoute(':controller/:id', array('action' => 'view')); // совпадает с news/1
 * new requestRoute(':controller/{:id}some', array(), array('id' => '\d+')); // совпадает с news/1some
 * </code>
 *
 * @package system
 * @subpackage request
 * @version 0.1.3
 */
class requestRoute implements iRoute
{
    /**
     * Префикс для placeholder в шаблоне
     *
     */
    const VARIABLE_PREFIX = ':';

    /**
     * Часть регулярного выражения, используемая по умолчанию
     *
     */
    const DEFAULT_REGEX = '[^/]+';

    /**
     * Разделить в регулярном выражении
     *
     */
    const REGEX_DELIMITER = '#';


    /**
     * Имя роута
     *
     * @var string
     */
    protected $name;

    /**
     * Шаблон
     *
     * @var string
     */
    protected $pattern;

    /**
     * Значения по умолчанию
     *
     * @var array
     */
    protected $defaults;

    /**
     * Иные требования к значению placeholder
     *
     * @var string
     */
    protected $requirements;

    /**
     * Части полученные после декомпозиции PATH
     *
     * @var array
     */
    protected $parts;

    /**
     * Регулярное выражение по которому шаблон сверяется с URL
     *
     * @var string
     */
    protected $regex;

    /**
     * Результат декомпозиции. Ключом в массиве является имя placeholder
     * или ключ, указанный в значениях по умолчанию
     *
     * @var array
     */
    protected $values;

    /**
     * Debug информация
     *
     * @var boolean
     */
    protected $debug;

    /**
     * Если true, то учитывается информация о языке
     *
     * @var boolean
     */
    protected $withLang = false;

    /**
     * Конструктор
     *
     * @param string $pattern шаблон
     * @param array $defaults значения по умолчанию
     * @param array $requirements иные требования к значению placeholder
     * @param boolean $debug при значении true отображается сгенерированное регулярное выражение
     */
    public function __construct($pattern, array $defaults = array(), array $requirements = array(), $debug = false)
    {
        $this->pattern = $pattern;
        $this->defaults = $defaults;
        $this->requirements = $requirements;
        $this->debug = $debug;
        $this->withLang = systemConfig::$i18n;
    }

    /**
     * Установка имени роута. Устанавливается только один раз
     *
     * @param string $name
     */
    public function setName($name)
    {
        if (!empty($this->name)) {
            throw new mzzRuntimeException('У Route уже есть имя - ' . $this->name);
        }
        $this->name = $name;
    }

    /**
     * Возвращение имени роута
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Проверка совпадения PATH с шаблоном.
     *
     * @param string $path полученный path из URL
     * @param boolean $debug режим отладки работы маршрутизатора
     * @return array|false
     */
    public function match($path, $debug = false)
    {
        if (empty($this->regex)) {
            $this->prepare();
        }

        $this->values = $this->defaults;

        if ($debug) {
            echo '<span style="background-color: #FCF4DA; padding: 0 3px;">' . $this->getName() . '</span>, ';
            echo '<span style="background-color: #D9F2FC; padding: 0 3px;">' . $this->pattern . '</span>, ';
            echo '<span style="background-color: #FBDFDA; padding: 0 3px;">' . $this->regex . '</span>, ';
            echo '<span style="background-color: #E5FBE2; padding: 0 3px;">' . $path . "</span><br />\r\n";
        }

        if (preg_match_all($this->regex, $path, $matches, PREG_SET_ORDER)) {
            unset($matches[0][0]);
            foreach ($matches[0] as $i => $match) {
                if($this->parts[$i - 1]['isVar'] && $match !== '') {
                    $this->values[$this->parts[$i - 1]['name']] = $match;
                }
            }

            // Если в конце шаблона содержится "*", то неизвестные параметры разбиваем
            // по принципу нечетные - ключи, четные - значения
            if (isset($this->values['*'])) {
                $params = explode('/', trim($this->values['*'], '/'));
                while ($key = current($params)) {
                    next($params);
                    if (!isset($this->values[$key])) {
                        $this->values[$key] = current($params);
                    }
                    next($params);
                }
            }
            return $this->values;
        }

        return false;
    }

    /**
     * Генерирует регулярное выражение, по которому будет выполнена проверка
     * на совпадение PATH с шаблоном
     *
     */
    protected function prepare()
    {
        $this->parts = preg_split('#(?:\{?(\\\?\:[a-z_]*)\}?)|(/\*$)#i', $this->pattern, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $this->regex = self::REGEX_DELIMITER . '^';

        if ($this->withLang) {
            array_unshift($this->parts, ':lang', '/');
            $this->requirements['lang'] = '^[a-z]{2}(?=/)|^[a-z]{2}(?=/?)$';
            $this->defaults['lang'] = '';
        }

        foreach ($this->parts as $i => $part) {
            if($part[0] === self::VARIABLE_PREFIX) {
                $part = substr($part, 1);
                $regex = isset($this->requirements[$part]) ? $this->requirements[$part] : self::DEFAULT_REGEX;
                $this->parts[$i] = array('name'=> $part, 'isVar' => true, 'regex' => $regex);

                $prevPartName = ($i > 0) ? $this->parts[$i-1]['name'] : false;

                if (array_key_exists($part, $this->defaults)) {
                    if ($prevPartName !== '/' && substr($prevPartName, -1) === '/') {
                        $this->regex = substr($this->regex, 0, -2) . ')/?';
                    }
                    $postfix = ')?';
                    $withDefault = true;
                } else {
                    $postfix = ')';
                    $withDefault = false;
                }

                $prefix = ($withDefault && $prevPartName === '/') ? '?(' : '(';

            } elseif ($part === '/*') {
                $this->parts[$i] = array('name'=> '*', 'isVar' => true, 'regex' => '/?(.*)');
                $prefix = '';
                $postfix = '';
            } else {
                if ($part[0] == '\\' && $part[1] == self::VARIABLE_PREFIX) {
                    $part = substr($part, 1);
                }
                $this->parts[$i] = array('name'=> $part, 'isVar' => false, 'regex' => preg_quote($part, self::REGEX_DELIMITER));
                $prefix = '(';
                $postfix = ($this->withLang && $i === 1) ? ')?' : ')';
            }

            $this->regex .= $prefix . $this->parts[$i]['regex'] . $postfix;
        }

        $this->regex .= '$' . self::REGEX_DELIMITER . 'i';
    }

    /**
     * Включение учета языка
     *
     */
    public function enableLang()
    {
        $this->withLang = true;
    }

    /**
     * Собирает из массива параметров path для URL согласно данному Route
     *
     * @param array $values массив именованных параметров
     * @return string готовый path для URL
     */
    public function assemble($values = array())
    {
        static $lang;
        if (empty($lang)) {
            $lang = systemToolkit::getInstance()->getLocale()->getName();
        }

        if (empty($this->parts)) {
            $this->prepare();
        }
        $url = '';
        foreach ($this->parts as $part) {
            if ($part['isVar']) {
                if (array_key_exists($part['name'], $values)) {
                    // @todo осталось лишь придумать что-то с роутом withId в JIP
                    $regex = isset($this->requirements[$part['name']]) ? self::REGEX_DELIMITER . $this->requirements[$part['name']] . self::REGEX_DELIMITER : false;
                    $regex = false;
                    if ($regex && !preg_match($regex, $values[$part['name']])) {
                        throw new mzzRuntimeException('Значение "' . $values[$part['name']] . '" не соответствует регулярному выражению "' . $this->requirements[$part['name']] . '"');
                    }
                    $url .= $values[$part['name']];
                    unset($values[$part['name']]);
                } elseif ($part == "*") {
                    foreach($values as $key => $value) {
                        $url .= '/' . $key . '/' . $value;
                    }
                } elseif (isset($this->defaults[$part['name']])) {
                    if ($part['name'] == 'lang') {
                        $url = $lang . $url;
                    } else {
                        $url = substr($url, 0, -1);
                    }
                } else {
                    throw new mzzRuntimeException('Отсутствует значение для Route: ' . $part['name']);
                }
            } else {
                $url .= $part['name'];
            }
        }
        if (substr($url, -1) == '/') {
            $url = substr($url, 0, -1);
        }
        return $url;
    }

}

?>
