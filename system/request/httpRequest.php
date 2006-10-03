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
 * httpRequest: класс для работы с суперглобальными массивами.
 * Доступ к httpRequest можно получить через Toolkit.
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
     * свойство для временного хранения сохранённых параметров
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
     * Конструктор.
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
     * Метод получения переменной из суперглобального массива
     *
     * @param string  $name  имя переменной
     * @param string  $type  тип, в который будет преобразовано значение
     * @param integer $scope бинарное число, определяющее в каких массивах искать переменную
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
     * Преобразователь значения переменной $result к типу $type
     * Если $result массив, то из него извлекается первый элемент и
     * дальнейшие преобразования происходят только с этим элементом
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
     * Возвращает true если используется защищенный протокол HTTPS
     *
     * @return boolean
     */
    public function isSecure()
    {
        $temp = $this->getServer('HTTPS');
        return ($temp === 'on');
    }

    /**
     * Метод возвращает протокол, который был использован для передачи данных.
     *
     * @return string|null возможные варианты: GET, HEAD, POST, PUT
     */
    public function getMethod()
    {
        return $this->getServer('REQUEST_METHOD');
    }

    /**
     * Метод получения переменной из суперглобального массива _SERVER
     *
     * @param string $name имя переменной
     * @return string|null
     */
    private function getServer($name)
    {
        return ( isset($_SERVER[$name]) ) ? $_SERVER[$name] : null;
    }

    /**
     * Возвращает текущую секцию
     *
     * @return string
     */
    public function getSection()
    {
        return $this->get('section', 'mixed', SC_PATH);
    }

    /**
     * Установка определенного параметра
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
     * Установка массива параметров
     *
     * @param array $params
     */
    public function setParams(Array $params)
    {
        $this->params = new arrayDataspace($params);
    }

    /**
     * Возврат массива параметров
     *
     * @return array
     */
    public function & getParams()
    {
        return $this->params->export();
    }

    /**
    * Получение текущего урла
    *
    * @todo сделать чтобы возвращал полностью весь адрес
    * @return string URL
    */
    public function getUrl()
    {
        return $this->getVars->get('path');
    }

    /**
     * сохранение текущего состояния параметров<br>
     * (SC_PATH)
     *
     */
    public function save()
    {
        $this->savedParams = clone $this->params;
    }

    /**
     * восстановление сохранённого ранее состояния
     *
     */
    public function restore()
    {
        $this->params = clone $this->savedParams;
    }

}

?>