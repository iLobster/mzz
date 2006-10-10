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
 * @version 0.7
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
    protected $savedParams;

    /**
     * Params
     *
     */
    protected $params = array();
    /**#@-*/

    /**
     *  онструктор.
     *
     */
    public function __construct()
    {
        $this->postVars = new arrayDataspace($_POST);
        $this->getVars = new arrayDataspace($_GET);
        $this->cookieVars = new arrayDataspace($_COOKIE);
        $this->setParams(array());
        $this->savedParams = new arrayDataspace();
    }

    /**
     * ћетод получени€ переменной из суперглобального массива
     *
     * @param string  $name  им€ переменной
     * @param string  $type  тип, в который будет преобразовано значение
     * @param integer $scope бинарное число, определ€ющее в каких массивах искать переменную
     * @return string|null
     */
    public function get($name, $type = null, $scope = SC_REQUEST)
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
        $temp = $this->getServer('HTTPS');
        return ($temp === 'on');
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
        return ( isset($_SERVER[$name]) ) ? $_SERVER[$name] : null;
    }

    /**
     * ¬озвращает текущую секцию
     *
     * @return string
     */
    public function getSection()
    {
        return $this->get('section', 'mixed', SC_PATH);
    }

    public function getAction()
    {
        return $this->get('action', 'mixed', SC_PATH);
    }

    /**
     * ”становка определенного параметра
     *
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value)
    {
        if (($this->params instanceof iDataspace) == false) {
            $this->setParams(array());
        }
        $this->params->set($name, $value);
    }

    /**
     * ”становка массива параметров
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
        return trim(preg_replace('/\/{2,}/', '/', $this->get('path', 'mixed', SC_REQUEST)), '/');
    }

    /**
     * сохранение текущего состо€ни€ параметров
     *
     */
    public function save()
    {
        $this->savedParams = clone $this->params;
    }

    /**
     * восстановление сохранЄнного ранее состо€ни€
     *
     */
    public function restore()
    {
        $this->params = clone $this->savedParams;
    }

}

?>