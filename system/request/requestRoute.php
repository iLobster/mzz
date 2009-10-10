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
 * new requestRoute(':module/:id/:action'); // совпадает с news/1/view
 * new requestRoute(':module/:id', array('action' => 'view')); // совпадает с news/1
 * new requestRoute(':module/{:id}some', array(), array('id' => '\d+')); // совпадает с news/1some
 * </code>
 *
 * @package system
 * @subpackage request
 * @version 0.1.5
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
    const DEFAULT_REGEX = '[^/]';

    /**
     * Разделить в регулярном выражении
     *
     */
    const REGEX_DELIMITER = '#';

    protected $part_delimiter = '/';

    protected $default_regex = '[^/]';

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
    protected $values = array();

    /**
     * Debug информация
     *
     * @var boolean
     */
    protected $debug;

    /**
     * Add/extract the lang from the path
     *
     * @var boolean
     */
    protected $withLang = false;

    protected $prepends = array();

    protected $matchedPath;

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
        $this->withLang = systemConfig::$i18nEnable;
    }

    /**
     * Установка имени роута. Устанавливается только один раз
     *
     * @param string $name
     */
    public function setName($name)
    {
        if (!empty($this->name)) {
            throw new mzzRuntimeException('Route already has a name: ' . $this->name);
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
     * Adds a route to the prepend route's list that will be executed before the main route
     *
     * @param iRoute $route
     */
    public function prepend(iRoute $route)
    {
        $this->prepends[] = $route;
    }

    /**
     * Проверка совпадения PATH с шаблоном.
     *
     * @param string $path полученный path из URL
     * @param boolean $debug режим отладки работы маршрутизатора
     * @return array|false
     */
    public function match($path, $partial = false, $debug = false)
    {
        if (empty($this->regex)) {
            $this->prepare($partial);
        }

        $this->values = $this->defaults;

        if (!$this->executePrepends($path, $partial)) {
            return false;
        }

        if ($debug) {
            $this->dumpParameters($this->getName(), $this->pattern, $this->regex, $path);
        }

        if (preg_match_all($this->regex, $path, $matches, PREG_SET_ORDER)) {
            $this->setMatchedPath($matches[0][0]);
            unset($matches[0][0]);
            foreach ($matches[0] as $i => $match) {
                if($this->parts[$i - 1]['isVar'] && $match !== '') {
                    $this->values[$this->parts[$i - 1]['name']] = $match;
                }
            }

            if (isset($this->values['*'])) {
                $this->replaceStar();
            }
            return $this->values;
        }

        return false;
    }

    protected function executePrepends(&$path, $partial)
    {
        foreach ($this->prepends as $route) {
            if ($result = $route->match($path, $partial)) {
                $this->values += $result;

                if ($subPath = $route->getMatchedPath()) {
                    $path = substr($path, strlen($subPath) + 1);
                }
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * Разбивает соответствующие шаблону "всё" параметры по принципу нечетные - ключи, четные - значения
     *
     */
    protected function replaceStar()
    {
        $params = explode($this->part_delimiter, trim($this->values['*'], $this->part_delimiter));
        while ($key = current($params)) {
            next($params);
            if (!isset($this->values[$key])) {
                $this->values[$key] = current($params);
            }
            next($params);
        }
    }

    protected function addLang()
    {
        array_unshift($this->parts, ':lang', '/');
        $this->requirements['lang'] = '^[a-z]{2}(?=/)|^[a-z]{2}(?=/?)$';
        $this->defaults['lang'] = '';
    }

    /**
     * Генерирует регулярное выражение, по которому будет выполнена проверка
     * на совпадение PATH с шаблоном
     *
     */
    protected function prepare($partial = false)
    {
        $this->parts = preg_split('#(?:\{?(\\\?\:[a-z_]*)\}?)|(/\*$)#i', $this->pattern, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $this->regex = self::REGEX_DELIMITER . '^';

        if ($this->withLang) {
            $this->addLang();
        }

        foreach ($this->parts as $i => $part) {
            if($part[0] === self::VARIABLE_PREFIX) {
                // route variable
                $part = substr($part, 1);
                if (isset($this->requirements[$part])) {
                    $regex = $this->requirements[$part];
                } else {
                    // чтобы идентификатор языка дефолтная регулярка не приняла за свое устанавливаем
                    // условие "более 3 символов" если она идет сразу же за регуляркой для языка
                    $regex = self::DEFAULT_REGEX . ($this->withLang && $i == 2 ? '{3,}' : '+');
                }

                $this->parts[$i] = array('name'=> $part, 'isVar' => true, 'regex' => $regex);

                $prevPartName = ($i > 0) ? $this->parts[$i-1]['name'] : false;

                $postfix = ')';
                if ($withDefault = array_key_exists($part, $this->defaults)) {
                    if ($prevPartName !== $this->part_delimiter && substr($prevPartName, -1) === $this->part_delimiter) {
                        $this->regex = substr($this->regex, 0, -2) . ')/?';
                    }
                    $postfix .= '?';
                }

                $prefix = ($withDefault && $prevPartName === $this->part_delimiter) ? '?(' : '(';

            } elseif ($part === '/*') {
                // grab all params
                $this->parts[$i] = array('name'=> '*', 'isVar' => true, 'regex' => '/?(.*)');
                $prefix = '';
                $postfix = '';
            } else {
                // static parameter
                if ($part[0] == '\\' && $part[1] == self::VARIABLE_PREFIX) {
                    $part = substr($part, 1);
                }
                $this->parts[$i] = array('name'=> $part, 'isVar' => false, 'regex' => preg_quote($part, self::REGEX_DELIMITER));
                $prefix = '(';
                $postfix = ($this->withLang && $i === 1) ? ')?' : ')';
            }

            $this->regex .= $prefix . $this->parts[$i]['regex'] . $postfix;
        }

        $this->regex .= ($partial ? '' : '$') . self::REGEX_DELIMITER . 'i';
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
        if ($this->withLang) {
            $currentLang = systemToolkit::getInstance()->getLocale()->getName();
        }

        if (empty($this->parts)) {
            $this->prepare();
        }

        $url = array();
        $url_names = array();

        foreach ($this->parts as $part) {
            if ($part['isVar']) {
                if (array_key_exists($part['name'], $values)) {
                    $url[] = $values[$part['name']];
                    $url_names[] = $part['name'];
                    unset($values[$part['name']]);
                } elseif (isset($this->defaults[$part['name']])) {
                    if ($part['name'] == 'lang' && $this->withLang) {
                        $url[] = $currentLang;
                        $url_names[] = 'lang';
                    }
                } else {
                    throw new mzzRuntimeException('No value for a token, ' . $this->name . ' route: ' . $part['name']);
                }
            } else {
                $url[] = $part['name'];
                $url_names[] = $part['name'];
            }
        }

        $break = -1;
        foreach (array_reverse($url_names, true) as $key => $val) {
            if ($val == $this->part_delimiter || (isset($this->defaults[$val]) && $val != 'lang' && $url[$key] == $this->defaults[$val])) {
                $break = $key;
            } else {
                break;
            }
        }

        if ($break != -1) {
            $url = array_slice($url, 0, $break);
        }

        $url = implode('', $url);

        return trim($url, $this->part_delimiter);
    }

    public function getValues()
    {
        return $this->values;
    }

    public function getParts()
    {
        if (empty($this->parts)) {
            $this->prepare();
        }

        return $this->parts;
    }

    public function getDefaults()
    {
        return $this->defaults;
    }

    public function setMatchedPath($path)
    {
        $this->matchedPath = $path;
    }

    public function getMatchedPath()
    {
        return $this->matchedPath;
    }


    protected function dumpParameters($name, $pattern, $regex, $path)
    {
        $span = '<span style="background-color: #%s; padding: 0 3px;">%s</span>';
        printf($span . ', ', 'FCF4DA', $name);
        printf($span . ', ', 'D9F2FC', $pattern);
        printf($span . ', ', 'FBDFDA', $regex);
        printf($span . "<br />\r\n", 'E5FBE2', $path);
    }
}

?>
