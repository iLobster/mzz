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

fileLoader::load('request/iRequest');

/**
 * httpRequest: класс дл€ работы с суперглобальными массивами.
 * ƒоступ к httpRequest можно получить через Toolkit.
 *
 * Examples:
 * <code>
 * $httprequest->get('var', SC_GET | SC_COOKIE);
 * $httprequest->get('var2');
 * </code>
 *
 * @package system
 * @subpackage request
 * @version 0.7.1
 */

define('SC_GET', 1);
define('SC_POST', 2);
define('SC_REQUEST', SC_GET | SC_POST);
define('SC_COOKIE', 4);
define('SC_SERVER', 8);
define('SC_PATH', 16);

class httpRequest implements iRequest
{
    /**#@+
    * @var array
    */
    /**
     * POST-данные
     */
    protected $postVars;

    /**
     * GET-данные
     */
    protected $getVars;

    /**
     * Cookie
     */
    protected $cookieVars;

    /**
     * свойство дл€ временного хранени€ сохранЄнных параметров
     *
     */
    protected $saved;

    /**
     * ѕараметры
     *
     */
    protected $params = null;
    /**#@-*/

    /**
     * —екци€
     *
     * @var string
     */
    protected $section;

    /**
     * ƒействие
     *
     * @var string
     */
    protected $action;

    /**
     *  онструктор.
     *
     */
    public function __construct()
    {
        $this->postVars = new arrayDataspace($_POST);
        $this->getVars = new arrayDataspace($_GET);
        $this->cookieVars = new arrayDataspace($_COOKIE);
        $this->params = new arrayDataspace();
    }

    /**
     * ћетод получени€ переменной из суперглобального массива
     *
     * @param string  $name  им€ переменной
     * @param string  $type  тип, в который будет преобразовано значение
     * @param integer $scope бинарное число, определ€ющее в каких массивах искать переменную
     * @return string|null
     */
    public function get($name, $type = 'mixed', $scope = SC_REQUEST)
    {
        $result = null;

        $done = false;
        if (!$done && $scope & SC_SERVER && !is_null($result = $this->getServer($name))) {
            $done = true;
        }

        if (!$done && $scope & SC_COOKIE && !is_null($result = $this->cookieVars->get($name))) {
            $done = true;
        }

        if (!$done && $scope & SC_POST && !is_null($result = $this->postVars->get($name))) {
            $done = true;
        }

        if (!$done && $scope & SC_GET && !is_null($result = $this->getVars->get($name))) {
            $done = true;
        }

        if (!$done && $scope & SC_PATH && !is_null($result = $this->params->get($name))) {
            $done = true;
        }

        if (!empty($result) && $this->isAjax()) {
            if (is_array($result)) {
                array_walk_recursive($result, array($this, 'decodeUTF8'));
            } else {
                $result = $this->decodeUTF8($result);
            }
        }

        if (is_null($result) || (empty($type) || $type == 'mixed')) {
            return $result;
        } else {
            return $this->convertToType($result, $type);
        }
    }

    /**
     * ѕреобразователь значени€ переменной $result к типу $type
     * ≈сли $result массив, то из него извлекаетс€ первый элемент и
     * дальнейшие преобразовани€ происход€т только с этим элементом
     *
     * @param mixed $result значение полученное из URI
     * @param string $type тип, в который будет преобразовано значение
     * @return mixed
     */
    public function convertToType($result, $type)
    {
        $validTypes = array('array', 'integer', 'boolean', 'string');
        if (gettype($result) == 'array' && $type != 'array') {
            $result = array_shift($result);
        }

        if (gettype($result) != $type && in_array($type, $validTypes)) {
            settype($result, $type);
        }
        return $result;
    }

    /**
     * ¬озвращает true если используетс€ защищенный протокол HTTPS
     *
     * @return boolean
     */
    public function isSecure()
    {
        $protocol = $this->getServer('HTTPS');
        return ($protocol === 'on');
    }

    /**
     * ¬озвращает true если используетс€ AJAX
     *
     * @return boolean
     */
    public function isAjax()
    {
        return isset($_REQUEST['ajax']);
    }

    /**
     * ћетод возвращает протокол, который был использован дл€ передачи данных.
     *
     * @return string|null возможные варианты: GET, HEAD, POST, PUT
     */
    public function getMethod()
    {
        return $this->getServer('REQUEST_METHOD');
    }

    /**
     * ћетод получени€ переменной из суперглобального массива _SERVER
     *
     * @param string $name им€ переменной
     * @return string|null
     */
    private function getServer($name)
    {
        return isset($_SERVER[$name]) ? $_SERVER[$name] : null;
    }

    /**
     * ¬озвращает текущую секцию
     *
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * ”станавливает текущую секцию
     *
     * @param string $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * ¬озвращает текущее действие
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * ”станавливает текущее действие
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * ”становка определенного параметра
     *
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value)
    {
        $this->params->set($name, $value);
    }

    /**
     * ”становка массива параметров. —уществующие параметры будут уничтожены
     *
     * @param array $params
     */
    public function setParams(Array $params)
    {
        $this->params = new arrayDataspace($params);
    }

    /**
     * ¬озврат массива параметров
     *
     * @return array
     */
    public function & getParams()
    {
        return $this->params->export();
    }

    /**
     * ѕолучение текущего урла, игнориру€ путь
     *
     * @return string URL
     */
    public function getUrl()
    {
        $protocol = $this->isSecure() ? 'https' : 'http';
        $port = $this->get('SERVER_PORT', 'mixed', SC_SERVER);
        $port = ($port == '80') ? '' : ':' . $port;

        return $protocol . '://' . $this->get('HTTP_HOST', 'mixed', SC_SERVER) . $port . SITE_PATH;
    }

    /**
     * ѕолучение текущего урла c путем
     *
     * @return string URL
     */
    public function getRequestUrl()
    {
        return $this->getUrl() . '/' . $this->getPath();
    }

    /**
     * ѕолучение текущего пути
     *
     * @return string PATH
     */
    public function getPath()
    {
        return trim(preg_replace('/(%2F)+/', '/', urlencode($this->get('path', 'mixed', SC_REQUEST))), '/');
    }

    /**
     * сохранение текущего состо€ни€ параметров
     *
     */
    public function save()
    {
        $this->saved[] = array('params' => $this->params->export(), 'section' => $this->getSection(), 'action' => $this->getAction());
    }

    /**
     * восстановление сохранЄнного ранее состо€ни€
     *
     */
    public function restore()
    {
        if (!empty($this->saved)) {
            $saved = array_pop($this->saved);
            $this->params->import($saved['params']);
            $this->setSection($saved['section']);
            $this->setAction($saved['action']);
            return true;
        }
        return false;
    }


    /**
     * декодирует данные из кодировки UTF-8 в windows-1251
     *
     * @param string $value строка в UTF-8
     * @return string строка в windows-1251
     */
    public function decodeUTF8(&$value)
    {
        static $table = array();

        if (empty($table)) {
            for ($i = 0x100; $i--;) {
                if (function_exists('iconv')) {
                    if ('' !== $c = iconv('windows-1251','UTF-32BE//IGNORE',chr($i))) {
                        $table[$c] = chr($i);
                    }
                } elseif (function_exists('mb_convert_encoding')) {
                    if ('?' !== $c = mb_convert_encoding(chr($i),'UTF-32BE', 'windows-1251')) {
                        $table[$c] = chr($i);
                    }
                } else {
                    throw new mzzRuntimeException('Value could not be converted from UTF-8');
                }
            }
        }

        if (function_exists('iconv')) {
            $str = iconv('UTF-8', 'UTF-32BE', $value);
        } elseif (function_exists('mb_convert_encoding')) {
            $str = mb_convert_encoding($value, 'UTF-32BE', 'UTF-8');
        }
        $result = '';
        $len = strlen($str);
        for ($i = 0; $i < $len; $i += 4) {
            if (isset($table[$s = substr($str, $i, 4)])) {
               $result .= $table[$s];
            } else {
               $result .= '&#'.hexdec(bin2hex($s)).';';
            }
        }
        $value = $result;
        return $value;
    }
}

?>