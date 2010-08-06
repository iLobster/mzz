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
 * $httpRequest->getBoolean('var', SC_GET | SC_COOKIE);
 * $httpRequest->getString('var2', SC_POST);
 * $httpRequest->getInteger('var2');
 * </code>
 *
 * @package system
 * @subpackage request
 * @version 0.9.2
 */

define('SC_GET', 1);
define('SC_POST', 2);
define('SC_REQUEST', SC_GET | SC_POST);
define('SC_COOKIE', 4);
define('SC_PATH', 8);
define('SC_SERVER', 16);
define('SC_FILES', 32);

class httpRequest implements iRequest
{
    /**#@+
    * @var array
    */
    /**
     * POST-данные
     */
    protected $post;

    /**
     * GET-данные
     */
    protected $get;

    /**
     * Данные суперглобала $_FILES
     */
    protected $files;

    /**
     * Cookie
     */
    protected $cookie;

    /**
     * свойство для временного хранения сохранённых параметров
     *
     */
    protected $saved;

    /**
     * Параметры из пути
     *
     */
    protected $path = null;
    /**#@-*/

    /**
     * Текущий модуль
     *
     * @var string
     */
    protected $module;

    /**
     * Текущее действие
     *
     * @var string
     */
    protected $action;

    /**
     * Первоначально запрошенный модуль
     *
     * @var string
     */
    protected $requestedModule = false;

    /**
     * Первоначально запрошенное действие
     *
     * @var string
     */
    protected $requestedAction = false;

    /**
     * Первоначально запрошенные параметры
     *
     * @var string
     */
    protected $requestedParams = null;

    protected $forwarded = null;

    /**
     * Конструктор.
     *
     */
    public function __construct()
    {
        $this->refresh();
    }

    /**
     * Возвращает строковое значение из определенных областей
     *
     * @param string $name
     * @param integer $scope бинарное число, определяющее в каких массивах искать переменную
     * @return string|null
     */
    public function getString($name, $scope = SC_PATH, $default = null)
    {
        return $this->readScope($name, $scope, 'string', $default);
    }

    /**
     * Возвращает целочисленное значение из определенных областей
     *
     * @param string $name
     * @param integer $scope бинарное число, определяющее в каких массивах искать переменную
     * @return integer|null
     */
    public function getInteger($name, $scope = SC_PATH, $default = null)
    {
        return $this->readScope($name, $scope, 'integer', $default);
    }

    /**
     * Возвращает любое числовое значение из определенных областей
     *
     * @param string $name
     * @param integer $scope бинарное число, определяющее в каких массивах искать переменную
     * @return integer|float|null
     */
    public function getNumeric($name, $scope = SC_PATH, $default = null)
    {
        return $this->readScope($name, $scope, 'numeric', $default);
    }

    /**
     * Возвращает массив из определенных областей
     *
     * @param string $name
     * @param integer $scope бинарное число, определяющее в каких массивах искать переменную
     * @return array|null
     */
    public function getArray($name, $scope = SC_PATH, $default = null)
    {
        return $this->readScope($name, $scope, 'array', $default);
    }

    /**
     * Возвращает булево значение из определенных областей
     *
     * @param string $name
     * @param integer $scope бинарное число, определяющее в каких массивах искать переменную
     * @return boolean|null
     */
    public function getBoolean($name, $scope = SC_PATH, $default = null)
    {
        return $this->readScope($name, $scope, 'boolean', $default);
    }

    /**
     * Возвращает значение любого типа из определенных областей
     *
     * @param string $name
     * @param integer $scope бинарное число, определяющее в каких массивах искать переменную
     * @return mixed
     */
    public function getRaw($name, $scope = SC_PATH, $default = null)
    {
        return $this->readScope($name, $scope, 'mixed', $default);
    }

    /**
     * Метод для обратной совместимости с предыдущей версией класса, обёртка над readScope
     *
     * @param string $name
     * @param string $type
     * @param integer $scope
     * @return mixed
     * @see httpRequest::readScope()
     */
    public function get($name, $type = 'mixed', $scope = SC_PATH, $default = null)
    {
        return $this->readScope($name, $scope, $type, $default);
    }

    /**
     * Метод получения переменной из суперглобального массива
     *
     * @param string  $name  имя переменной
     * @param integer $scope бинарное число, определяющее в каких массивах искать переменную
     * @param string  $type  тип, в который будет преобразовано значение
     * @return string|null
     */
    protected function readScope($name, $scope = SC_PATH, $type = 'mixed', $default = null)
    {
        $result = null;

        if ($bracket = strpos($name, '[')) {
            $indexName = substr($name, $bracket);
            $name = substr($name, 0, $bracket);
        }

        $scopes = array(SC_PATH => 'path', SC_COOKIE => 'cookie', SC_POST => 'post', SC_GET => 'get', SC_FILES => 'files');
        foreach ($scopes as $key => $scope_name) {
            if ($scope & $key) {
                $result = $this->$scope_name->get($name);
                if (!is_null($result)) {
                    break;
                }
            }
        }

        if (isset($indexName)) {
            $result = arrayDataspace::extractFromArray($indexName, $result);
        }

        if (is_null($result)) {
            return (is_null($default) || empty($type) || $type == 'mixed') ? $default : $this->setType($default, $type);
        }

        if (empty($type) || $type == 'mixed') {
            return $result;
        } else {
            return $this->setType($result, $type);
        }
    }

    /**
     * Приведение к определенному типу значения
     * Если $value массив, а требуется скалярное значение, то из него извлекается первый элемент и
     * дальнейшие преобразования происходят только с этим элементом.
     *
     * @param mixed $value значение
     * @param string $type тип, к которому будет приведено значение
     * @return mixed
     */
    protected function setType($value, $type)
    {
        if (is_array($value) && $type != 'array') {
            $value = array_shift($value);
            if (!is_scalar($value)) {
                $value = null;
            }
        }

        if ($type == 'numeric') {
            return 0 + $value;
        }
        if (!is_null($value) && gettype($value) != $type) {
            settype($value, $type);
        }
        return $value;
    }

    /**
     * Возвращает true если используется защищенный протокол HTTPS
     *
     * @return boolean
     */
    public function isSecure()
    {
        return ($this->getServer('HTTPS') === 'on');
    }

    /**
     * Возвращает true если используется AJAX
     *
     * @todo убрать это или заменить на что-то, использующее HTTP заголовки
     * @return boolean
     */
    public function isAjax()
    {
        return isset($_REQUEST['ajax']);
    }

    /**
     * Возвращает true если используется JIP
     *
     * @return boolean
     */
    public function isJip()
    {
        return isset($_REQUEST['jip']);
    }

    /**
     * Возвращает метод, который был использован для доступа к страницам (данным).
     *
     * @return string|null GET, HEAD, POST, PUT, DELETE...
     */
    public function getMethod()
    {
        return $this->getServer('REQUEST_METHOD');
    }

    /**
     * Возвращает массив уникальных языков, которые поддерживает браузер клиента
     *
     * @return array
     */
    public function getAcceptLanguages()
    {
        preg_match_all('/[a-z]{2}/', $this->getServer('HTTP_ACCEPT_LANGUAGE'), $accept_langs);
        return array_unique($accept_langs[0]);
    }

    /**
     * Проверяет что метод запроса такой же, какой и переданный в аргументе
     *
     * @param string $method имя метода
     * @return boolean true если методы одинаковые, иначе false
     */
    public function isMethod($method)
    {
        return strtolower($method) == strtolower($this->getMethod());
    }

    /**
     * Получение текущего URL без запрошенного пути (но с SITE_PATH).
     * Пример: http://example.com:8080/mzz
     *
     * @return string URL
     */
    public function getUrl()
    {
        $scheme = $this->getScheme();

        return $scheme . '://' . $this->getHttpHost() . SITE_PATH;
    }

    public function getHttpHost()
    {
        $host = $this->getHost();
        $scheme = $this->getScheme();

        if (($scheme == 'http' && $host['port'] == 80) || ($scheme == 'https' && $host['port'] == 443)) {
            $host['port'] = '';
        } else {
            $host['name'] .= ':' . $host['port'];
        }

        return $host['name'];
    }

    public function getScheme()
    {
        return 'http' . ($this->isSecure() ? 's' : '');
    }

    /**
     * Получение полного URL.
     * Пример: http://example.com:8080/mzz/foo/bar/?baz=1
     *
     * @return string URL
     */
    public function getRequestUrl()
    {
        $get = $this->get->export();
        unset($get['path']);
        return $this->getUrl() . '/' . $this->getPath() . (!empty($get) ? '?' . http_build_query($get) : '');
    }

    /**
     * Возвращает порт из URL
     *
     * @return string
     */
    public function getUrlPort()
    {
        $host = $this->getHost();
        return $host['port'];
    }

    /**
     * Возвращает часть с именем хоста из URL
     *
     * @return string
     */
    public function getUrlHost()
    {
        $host = $this->getHost();
        return $host['name'];
    }

    /**
     * Возвращает запрошенный путь из URL
     *
     * @return string
     */
    public function getPath()
    {
        return trim(preg_replace('!/+!', '/', $this->readScope('path', SC_REQUEST)), '/');
    }

    /**
     * Устанавливает текущий модуль
     *
     * @param string $module
     */
    public function setModule($module)
    {
        if ($this->requestedModule === false) {
            $this->setRequestedModule($module);
        }
        $this->module = $module;
    }

    /**
     * Возвращает текущий модуль
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Устанавливает текущее действие
     * Первое установленное значение считается запрошенным действием
     *
     * @param string $action
     */
    public function setAction($action)
    {
        if ($this->requestedAction === false) {
            $this->setRequestedAction($action);
        }
        $this->action = $action;
    }

    /**
     * Возвращает текущее действие
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Возвращает первоначально запрошенный модуль
     *
     * @return string
     */
    public function getRequestedModule()
    {
        return $this->requestedModule;
    }

    /**
     * Устанавливает первоначально запрошенный модуль (once)
     *
     */
    public function setRequestedModule($module)
    {
        if ($this->requestedModule === false) {
            $this->requestedModule = $module;
        }
    }

    public function getForwardedTo()
    {
        return $this->forwarded;
    }

    public function setForwardedTo($module, $action)
    {
        $this->forwarded = array('module' => $module, 'action' => $action);
    }

    /**
     * Возвращает первоначально запрошенное действие
     *
     * @return string
     */
    public function getRequestedAction()
    {
        return $this->requestedAction;
    }

    /**
     * Устанавливает первоначально запрошенный модуль (once)
     *
     */
    public function setRequestedAction($action)
    {
        if ($this->requestedAction === false) {
            $this->requestedAction = $action;
        }
    }

    /**
     * Возвращает первоначально запрошенные параметры
     *
     * @return string
     */
    public function getRequestedParams()
    {
        return $this->requestedParams;
    }

    /**
     * Устанавливает первоначально запрошенные параметры.
     * Соответственно может быть вызвана только один раз
     *
     * @param array $params
     */
    public function setRequestedParams($params)
    {
        if ($this->requestedParams !== null) {
            return false;
        }
        $this->requestedParams = $params;
    }

    /**
     * Установка определенного параметра
     *
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value)
    {
        $this->path->set($name, $value);
    }

    /**
     * Установка массива параметров. Существующие параметры будут уничтожены
     *
     * @param array $path_values
     */
    public function setParams(Array $path_values)
    {
        $this->path = new arrayDataspace($path_values);
    }

    /**
     * Возвращает массив параметров
     *
     * @return array
     */
    public function & getParams()
    {
        return $this->path->export();
    }

    /**
     * Экспорт POST-данных
     *
     * @return array
     */
    public function exportPost()
    {
        return $this->post->export();
    }

    /**
     * Экспорт GET-данных.
     * Из результата исключен зарезервированный системный GET-параметр с индексом "path"
     * При необходимости получить значение этого параметра можно через
     * метод httpRequest::getPath()
     *
     * @return array
     */
    public function exportGet()
    {
        $get = $this->get->export();
        if (isset($get['path'])) {
            unset($get['path']);
        }
        return $get;
    }

    /**
     * Возвращает заголовки HTTP-запроса. Может использоваться не только
     * когда php установлен как apache-модуль
     *
     * @param boolean $manual флаг использования строенной функции apache_request_headers
     * @return array
     */
    public function getHeaders($manual = false)
    {
        if (!$manual && function_exists('apache_request_headers')) {
            if ($headers = apache_request_headers()) {
                return $headers;
            }
        }

        $headers = array();
        foreach (array_keys($_SERVER) as $key) {
            if (($val = substr($key, 0, 5)) == 'HTTP_' || (substr($key, 0, 8) == 'CONTENT_' && !$val = null)) {
                $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, strlen($val))))));
                $headers[$name] = $_SERVER[$key];
            }
        }

        return $headers;
    }

    /**
     * Инициализация
     *
     */
    public function initialize()
    {
        // @todo проверить на IIS
        if (!isset($_SERVER['REQUEST_URI']) && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false) {
            if(isset($_SERVER['HTTP_X_REWRITE_URL'])) {
                // Microsoft IIS with ISAPI_Rewrite
                $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
            } elseif(!isset($_SERVER['REQUEST_URI'])) {
                // Microsoft IIS with PHP in CGI mode
                $_SERVER['REQUEST_URI'] = $_SERVER['ORIG_PATH_INFO'] . (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '' ? '?' . $_SERVER['QUERY_STRING'] : '');
            }
        }

        // Microsoft IIS with PHP in CGI mode
        if (!isset($_SERVER['QUERY_STRING'])) {
            $_SERVER['QUERY_STRING'] = '';
        }
    }

    protected function getHost()
    {
        $name = 'localhost';
        if ($http_host = $this->getServer('HTTP_HOST')) {
            $name = $http_host;
        } elseif ($server_name = $this->getServer('SERVER_NAME')) {
            $name = $server_name;
        }

        if (strpos($name, ':')) {
            list($name, $port) = explode(':', $name);
        }

        $port = !empty($port) ? $port : (int)$this->getServer('SERVER_PORT');
        return array('name' => $name, 'port' => $port);
    }

    /**
     * Поиск значения по ключу в массиве $_SERVER или $_ENV
     * Если ничего не найдено, возвращает значение по умолчанию
     *
     * @param string|integer $key
     * @param mixed $default
     * @return mixed
     */
    public function getServer($key, $default = null)
    {
        if (array_key_exists($key, $_SERVER)) {
            return $_SERVER[$key];
        } elseif (array_key_exists($key, $_ENV)) {
            return $_ENV[$key];
        }

        return $default;
    }

    /**
     * сохранение текущего состояния параметров
     *
     */
    public function save()
    {
        $this->saved[] = array('path' => $this->path->export(), 'module' => $this->getModule(), 'action' => $this->getAction());
    }

    /**
     * восстановление сохранённого ранее состояния
     *
     */
    public function restore()
    {
        if (!empty($this->saved)) {
            $saved = array_pop($this->saved);
            $this->path->import($saved['path']);
            $this->setModule($saved['module']);
            $this->setAction($saved['action']);
            return true;
        }
        return false;
    }

    public function refresh()
    {
        $this->post = new arrayDataspace($_POST);
        $this->get = new arrayDataspace($_GET);
        $this->cookie = new arrayDataspace($_COOKIE);
        $this->path = new arrayDataspace();
        $this->files = new arrayDataspace($_FILES);
        $this->initialize();
    }
}

?>