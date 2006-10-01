<?php

class route
{
    const VARIABLE_PREFIX = ':';

    const DEFAULT_REGEX = '[^/]+';
    const REGEX_DELIMITER = '#';

    protected $pattern;
    protected $defaults;
    protected $requirements;
    protected $parts;
    protected $regex;
    protected $values;

    public function __construct($pattern, array $defaults = array(), array $requirements = array())
    {
        $this->pattern = $pattern;
        $this->defaults = $defaults;
        $this->requirements = $requirements;
    }

    public function prepareRegexp()
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

    public function match($path)
    {
        $this->values = $this->defaults;

        if (empty($this->regex)) {
            $this->prepareRegexp();
        }

        if (preg_match_all($this->regex, $path, $matches, PREG_SET_ORDER)) {
            unset($matches[0][0]);
            foreach ($matches[0] as $i => $match) {
                if($this->parts[$i - 1]['isVar'] && $match !== '') {
                    $this->values[$this->parts[$i - 1]['name']] = $match;
                }
            }

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

}
?>