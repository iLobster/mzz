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
 * @subpackage toolkit
 * @version $Id$
 */

/**
 * stdToolkit: стандартный Toolkit
 *
 * @package system
 * @subpackage toolkit
 * @version 0.2.5
 */
class stdToolkit extends toolkit
{
    /**#@+
     * @var object
     */
    private $request;
    private $response;
    private $session;
    private $router;
    private $configs;
    private $timer;
    private $user;
    private $objectIdGenerator;
    private $toolkit;
    private $validator;
    private $userPreferences;
    private $charsetDriver;
    private $i18n;
    private $view;
    /**#@-*/

    /**#@+
     * @var array
     */
    private $mapperStack = array();
    private $modules = array();
    private $mmCache = array('modules' => array(), 'mappers' => array());
    private $mmCacheChanged = false;
    /**#@-*/

    /**
     * Идентификатор языка
     *
     * @var integer
     */
    private $langId;
    private $locale;

    /**
     * Конструктор
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->toolkit = systemToolkit::getInstance();
        $cache = $this->getCache('long');
        $cache->get('appModuleMapper_cache', $this->mmCache);
        if (!is_array($this->mmCache) || !isset($this->mmCache['modules']) ||  !isset($this->mmCache['mappers'])) {
            $this->mmCache = array('modules' => array(), 'mappers' => array());
        }
    }

    /**
     * Возвращает объект Request
     *
     * @return httpRequest
     */
    public function getRequest()
    {
        if (empty($this->request)) {
            $this->request = new httpRequest();
        }

        return $this->request;
    }

    /**
     * Возвращает объект Response
     *
     * @return httpResponse
     */
    public function getResponse()
    {
        if (empty($this->response)) {
            $this->response = new httpResponse();
        }

        return $this->response;
    }

    /**
     * Возвращает объект Session
     *
     * @return object
     */
    public function getSession()
    {
        if (empty($this->session)) {
            fileLoader::load('session');
            $this->session = new session(systemConfig::$sessionStorageDriver);
        }

        return $this->session;
    }

    /**
     * Returns view object
     *
     * @return view
     */
    public function getView()
    {
        if (empty($this->view)) {
            fileLoader::load('template/view');
            $this->view = view::getInstance();
        }

        return $this->view;
    }
    /**
     * Returns simpleView with Smarty backend
     *
     * @return simpleView
     * @deprecated
     */
    public function getSmarty()
    {
        throw new mzzException("deprecated, use toolkit::getView() instead");
        return $this->getView('smarty');
    }

    /**
     * Возвращает объект requestRouter
     *
     * @param iRequest $request
     * @return object
     */
    public function getRouter($request = null)
    {
        if (empty($this->router)) {
            if (empty($request)) {
                $request = $this->toolkit->getRequest();
            }
            fileLoader::load('request/requestRoute');
            fileLoader::load('request/requestRouter');
            $this->router = new requestRouter($request);
        }

        return $this->router;
    }

    /**
     * Возвращает объект Timer
     *
     * @return object
     */
    public function getTimer()
    {
        if (empty($this->timer)) {
            fileLoader::load('timer');
            $this->timer = new timer();
            $this->timer->start();
        }

        return $this->timer;
    }

    /**
     * Возвращает объект текущего пользователя
     *
     * @return user
     */
    public function getUser()
    {
        if (empty($this->user)) {
            $this->setUser(null);
        }

        return $this->user;
    }

    public function setUser($user)
    {
        $userMapper = $this->getMapper('user', 'user');
        if (is_numeric($user)) {
            $user = $userMapper->searchByKey($user);
        }

        if (empty($user)) {
            $user = $userMapper->getGuest();
        }

        $this->getSession()->set('user_id', $user->getId());
        $this->getSession()->set('user_hash', ($user->getId() !=  MZZ_USER_GUEST_ID) ? $user->getHash() : null);
        $this->user = $user;
    }


    /**
     * Возвращает уникальный идентификатор необходимый для идентификации объектов
     *
     * @param string $name
     * @param boolean $generateNew
     * @return integer
     */
    public function getObjectId($name = null, $generateNew = true)
    {
        if (empty($this->objectIdGenerator)) {
            fileLoader::load('core/objectIdGenerator');
            $this->objectIdGenerator = new objectIdGenerator();
        }
        return $this->objectIdGenerator->generate($name, $generateNew);
    }

    /**
     * Return requested module
     *
     * @param string $moduleName
     * @return simpleModule
     */
    public function getModule($moduleName)
    {
        if (!isset($this->modules[$moduleName])) {
            $moduleClassName = $moduleName . 'Module';
            try {
                fileLoader::load($moduleName . '/' . $moduleClassName);
            } catch (mzzIoException $e) {
                throw new mzzModuleNotFoundException($moduleName);
            }

            if (!$this->getAppModuleCache($moduleName)) {
                $appModuleClassName = simpleModule::OVERRIDE_PREFIX . ucfirst($moduleName) . 'Module';
                try {
                    fileLoader::load($moduleName . '/' . $appModuleClassName);
                    $moduleClassName = $appModuleClassName;
                } catch (mzzIoException $e) {
                    $this->addAppModuleToCache($moduleName);
                }
            }

            $this->modules[$moduleName] = new $moduleClassName();
        }

        return $this->modules[$moduleName];
    }

    /**
     * Return requested Mapper for DO of Module, shorthand for systemToolkit::getModule($module)->getMapper($do)
     *
     * @param string $module name
     * @param string $do name
     * @return mapper
     */
    public function getMapper($module, $do)
    {
        return $this->getModule($module)->getMapper($do);
    }

    /**
     * Return cach object
     *
     * @return cache
     */
    public function getCache($cacheName = 'default')
    {
        fileLoader::load('cache');
        return cache::factory($cacheName);
    }

    /**
     * Return validator
     *
     * @return formValidator
     * @deprecated
     */
    public function getValidator()
    {
        throw new Exception('deprecated');
        return $this->validator;
    }

    /**
     * Set validator
     *
     * @param formValidator $value
     * @deprecated
     */
    public function setValidator($value)
    {
        throw new Exception('deprecated');
        $this->validator = $value;
    }

    /**
     * Set Request object
     *
     * @param iRequest $request
     * @return iRequest
     */
    public function setRequest($request)
    {
        $tmp = $this->request;
        $this->request = $request;
        return $tmp;
    }

    /**
     * Set new i18n object and return old one
     *
     * @param i18n $i18n
     * @return i18n
     */
    public function setI18n($i18n)
    {
        $tmp = $this->i18n;
        $this->i18n = $i18n;
        return $tmp;
    }

    /**
     * Return i18n object or new i18n if nothing set
     *
     * @return i18n
     */
    public function getI18n()
    {
        if ($this->i18n) {
            return $this->i18n;
        }
        return new i18n();
    }

    public function getLang()
    {
        if ($this->langId) {
            return $this->langId;
        }
        return $this->getLocale()->getId();
    }

    public function setLocale($name = null)
    {
        if (is_null($name)) {
            $this->locale = null;
            return;
        }

        try {
            $this->locale = new fLocale($name);
        } catch (mzzLocaleNotFoundException $e) {
            if (fLocale::isExists($name)) {
                throw $e;
            }
            $this->locale = new fLocale(systemConfig::$i18n);
        }
        // из-за проблем с преобразованием float-значений с запятой в sql
        // оставляем локаль для чисел прежней.
        $prev = setlocale(LC_NUMERIC, 0);
        setlocale(LC_ALL, $this->locale->getForSetlocale(), $this->locale->getLanguageName());
        setlocale(LC_NUMERIC, $prev);
    }

    public function getLocale()
    {
        if (!$this->locale) {
            if (!($lang = $this->getRequest()->getString('lang'))) {
                $lang = systemConfig::$i18n;
            }
            $this->setLocale($lang);
        }

        return $this->locale;
    }

    public function setLang($langId)
    {
        $prev = $this->langId;
        // @todo: добавить валидатор
        $this->langId = $langId;
        return $prev;
    }

    public function getUserPreferences()
    {
        if (!$this->userPreferences) {
            fileLoader::load('service/userPreferences');
            $this->userPreferences = new userPreferences();
        }

        return $this->userPreferences;
    }

    public function getCharsetDriver()
    {
        if (!$this->charsetDriver) {
            if (extension_loaded('mbstring')) {
                $class = 'utf8MbstringCharset';
            } elseif (extension_loaded('iconv')) {
                $class = 'utf8IconvCharset';
            } else {
                $class = 'utf8Charset';
            }
            fileLoader::load('i18n/charset/' . $class);
            $this->charsetDriver = new $class();
        }

        return $this->charsetDriver;
    }

    /**
     * Adds mapper to stack
     * @param string $class
     * @param mapper $mapper
     */
    public function addMapperToStack($class, mapper $mapper)
    {
        $this->mapperStack[$class] = $mapper;
    }

    /**
     * Returns mapper from stack
     * @param string $class
     * @return mapper|null
     */
    public function getMapperFromStack($class)
    {
        return isset($this->mapperStack[$class]) ? $this->mapperStack[$class] : null;
    }
    
    /**
     * Returns mapper stack
     * @return array:
     */
    public function getMapperStack()
    {
        return $this->mapperStack;
    }

    /**
     * Returns object to work with config file for requested module
     *
     * @param string $moduleName
     * @return simpleConfig
     */
    public function getConfig($moduleName) {
        if (!isset($this->configs[$moduleName])) {
            $this->configs[$moduleName] = new simpleConfig($moduleName);
        }
        return $this->configs[$moduleName];
    }

    /**
     *
     * @param string $moduleName
     */
    public function addAppModuleToCache($moduleName)
    {
        if (!isset($this->mmCache['modules'][$moduleName])) {
            $this->mmCacheChanged = true;
            $this->mmCache['modules'][$moduleName] = true;
        }
    }

    /**
     *
     * @param string $moduleName
     * @param string $mapperName
     */
    public function addAppMapperToCache($moduleName, $mapperName)
    {
        if (!isset($this->mmCache['mappers'][$moduleName][$mapperName])) {
            $this->mmCacheChanged = true;
            if (!isset($this->mmCache['mappers'][$moduleName]) || !is_array($this->mmCache['mappers'][$moduleName])) {
                $this->mmCache['mappers'][$moduleName] = array();
            }
            $this->mmCache['mappers'][$mapperName] = true;
        }
    }

    /**
     *
     * @param string $moduleName
     * @return boolean
     */
    public function getAppModuleCache($moduleName) {
        return isset($this->mmCache['modules'][$moduleName]);
    }

    /**
     *
     * @param string $moduleName
     * @param string $mapperName
     * @return boolean
     */
    public function getAppMapperCache($moduleName, $mapperName) {
        return isset($this->mmCache['mappers'][$moduleName][$mapperName]);
    }

    /**
     * Save list of not found Modules and Mappers in app path
     */
    protected function saveMMCache()
    {
        if ($this->mmCacheChanged) {
            $cache = $this->getCache('long');
            $cache->set('appModuleMapper_cache', $this->mmCache);
            $this->mmCacheChanged = false;
        }
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->saveMMCache();
    }
}
?>