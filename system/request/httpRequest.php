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
 * @version 0.6.1
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
     * Section
     *
     * @var string
     */
    protected $section;

    /**
     * Action
     *
     * @var string
     */
    protected $action;

    /**
     * массив дл€ временного хранени€ section и action между save() и restore()
     *
     * @var array
     */
    protected $savedSectionAction = array();

    /**
     *  онструктор.
     *
     * @param object $requestParser
     */
    public function __construct($requestParser)
    {
        $this->postVars = new arrayDataspace($_POST);
        $this->getVars = new arrayDataspace($_GET);
        $this->cookieVars = new arrayDataspace($_COOKIE);
        $this->requestParser = $requestParser;
        $this->import($this->get('path'));
        $this->savedParams = new arrayDataspace();
    }

    /**
     * ћетод получени€ переменной из суперглобального массива
     *
     * @param string  $name  им€ переменной
     * @param integer $scope бинарное число, определ€ющее в каких массивах искать переменную
     * @return string|null
     */
    public function get($name, $scope = SC_REQUEST)
    {
        $result = null;

        if ($scope & SC_SERVER && !is_null($result = $this->getServer($name))) {
            return $result;
        }

        if ($scope & SC_COOKIE && !is_null($result = $this->cookieVars->get($name))) {
            return $result;
        }

        if ($scope & SC_POST && !is_null($result = $this->postVars->get($name))) {
            return $result;
        }

        if ($scope & SC_GET && !is_null($result = $this->getVars->get($name))) {
            return $result;
        }

        if ($scope & SC_PATH && !is_null($result = $this->params->get($name))) {
            return $result;
        }

        return $result;
    }

    /**
     * »мпорт строки с section, action и параметрами
     *
     * @param string $path
     */
    public function import($path)
    {
        $this->requestParser->parse($this, $path);
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
     * ¬озвращает section
     *
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * ¬озвращает action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * ”становка section
     *
     * @param string $value
     */
    public function setSection($value)
    {
        $this->section = $value;
    }

    /**
     * ”становка action
     *
     * @param string $value
     */
    public function setAction($value)
    {
        $this->action = $value;
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
    public function getParams()
    {
        return $this->params->export();
    }

    /**
    * ѕолучение текущего урла
    * пока возвращает лишь path, исключа€ QUERY_STRING
    * @return string урл
    */
    public function getUrl()
    {
        return $this->getVars->get('path');
    }

    /**
     * сохранение текущего состо€ни€ параметров<br>
     * (SC_PATH)
     *
     */
    public function save()
    {
        $this->savedParams = clone $this->params;
        $this->savedSectionAction['action'] = $this->action;
        $this->savedSectionAction['section'] = $this->section;
    }

    /**
     * восстановление сохранЄнного ранее состо€ни€
     *
     */
    public function restore()
    {
        $this->params = clone $this->savedParams;
        $this->section = $this->savedSectionAction['section'];
        $this->action = $this->savedSectionAction['action'];
    }
}

?>