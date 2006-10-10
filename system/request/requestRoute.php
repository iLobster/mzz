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
 * requestRoute: ������� ��� ��������������.
 * ��� ���������� PATH � �������� ������� ���������� ��� ������������.
 *
 * �������:
 * <code>
 * new requestRoute(':controller/:id/:action'); // ��������� � news/1/view
 * new requestRoute(':controller/:id', array('action' => 'view')); // ��������� � news/1
 * new requestRoute(':controller/{:id}some', array(), array('id' => '\d+')); // ��������� � news/1some
 * </code>
 *
 * @todo ���������� URL (?)
 * @package system
 * @subpackage request
 * @version 0.1
 */
class requestRoute implements iRoute
{
    /**
     * ������� ��� placeholder � �������
     *
     */
    const VARIABLE_PREFIX = ':';

    /**
     * ����� ����������� ���������, ������������ �� ���������
     *
     */
    const DEFAULT_REGEX = '[^/]+';

    /**
     * ��������� � ���������� ���������
     *
     */
    const REGEX_DELIMITER = '#';

    /**
     * ������
     *
     * @var string
     */
    protected $pattern;

    /**
     * �������� �� ���������
     *
     * @var array
     */
    protected $defaults;

    /**
     * ���� ���������� � �������� placeholder
     *
     * @var string
     */
    protected $requirements;

    /**
     * ����� ���������� ����� ������������ PATH
     *
     * @var array
     */
    protected $parts;

    /**
     * ���������� ��������� �� �������� ������ ��������� � URL
     *
     * @var string
     */
    protected $regex;

    /**
     * ��������� ������������. ������ � ������� �������� ��� placeholder
     * ��� ����, ��������� � ��������� �� ���������
     *
     * @var array
     */
    protected $values;

    /**
     * Debug ����������
     *
     * @var boolean
     */
    protected $debug;


    /**
     * �����������
     *
     * @param string $pattern ������
     * @param array $defaults �������� �� ���������
     * @param array $requirements ���� ���������� � �������� placeholder
     * @param boolean $debug ��� �������� true ������������ ��������������� ���������� ���������
     */
    public function __construct($pattern, array $defaults = array(), array $requirements = array(), $debug = false)
    {
        $this->pattern = $pattern;
        $this->defaults = $defaults;
        $this->requirements = $requirements;
        $this->debug = $debug;
    }

    /**
     * �������� ���������� PATH � ��������.
     *
     * @param string $path ���������� path �� URL
     * @return array|false
     */
    public function match($path)
    {
        $this->values = $this->defaults;

        if (empty($this->regex)) {
            $this->prepareRegexp();
        }

        if ($this->debug) {
            echo 'pattern: \'' . $this->pattern . '\', regex: ' . $this->regex . ' with \'' . $path . '\'<br />';
        }

        if (preg_match_all($this->regex, $path, $matches, PREG_SET_ORDER)) {
            unset($matches[0][0]);
            foreach ($matches[0] as $i => $match) {
                if($this->parts[$i - 1]['isVar'] && $match !== '') {
                    $this->values[$this->parts[$i - 1]['name']] = $match;
                }
            }

            // ���� � ����� ������� ���������� "*", �� ����������� ��������� ���������
            // �� �������� �������� - �����, ������ - ��������
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
     * ���������� ���������� ���������, �� �������� ����� ��������� ��������
     * �� ���������� PATH � ��������
     *
     */
    protected function prepareRegexp()
    {

        $this->parts = preg_split('#(?:\{?(\:[a-z_]+)\}?)|(/\*$)#i', $this->pattern, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        $this->regex = self::REGEX_DELIMITER . '^';

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
                $this->parts[$i] = array('name'=> $part, 'isVar' => false, 'regex' => preg_quote($part, self::REGEX_DELIMITER));
                $prefix = '(';
                $postfix = ')';
            }

            $this->regex .= $prefix . $this->parts[$i]['regex'] . $postfix;
        }

        $this->regex .= '$' . self::REGEX_DELIMITER;
    }
}

?>