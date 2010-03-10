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
    private $smarty;
    private $router;
    private $config;
    private $timer;
    private $user;
    private $objectIdGenerator;
    private $toolkit;
    private $validator;
    private $userPreferences;
    private $charsetDriver;
    private $i18n;
    /**#@-*/

    /**#@+
     * @var array
     */
    private $mapperStack = array();
    private $modules = array();
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
    }

    /**
     * Возвращает объект Request
     *
     * @return object
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
     * @return object
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
     * Возвращает объект Smarty
     *
     * @return object
     */
    public function getSmarty()
    {
        if (empty($this->smarty)) {
            fileLoader::load('template/fSmarty');
            $smarty = new fSmarty();
            $smarty->template_dir = systemConfig::$pathToApplication . '/templates';
            $smarty->compile_dir = systemConfig::$pathToTemp . '/templates_c';
            $oldPluginsDirs = $smarty->plugins_dir;
            $smarty->plugins_dir = array();
            $smarty->allow_php_tag = true;
            $smarty->default_template_handler_func = array($smarty, 'resolveFilePath');
            if (is_dir($appdir = systemConfig::$pathToApplication . '/template/plugins')) {
                $smarty->plugins_dir[] = $appdir;
            }
            $smarty->plugins_dir[] = systemConfig::$pathToSystem . '/template/plugins';
            $smarty->plugins_dir = array_merge($smarty->plugins_dir, $oldPluginsDirs);

            $smarty->debugging = DEBUG_MODE;
            $smarty->assign('SITE_PATH', rtrim(SITE_PATH, '/'));

            fileLoader::load('template/plugins/modifier.filesize');
            $smarty->register_modifier('filesize', 'smarty_modifier_filesize');

            $smarty->register_object('form', new form());

            fileLoader::load('service/blockHelper');
            $smarty->register_object('fblock', $fblock = blockHelper::getInstance());
            $smarty->assign('fblock', $fblock);

            fileLoader::load('template/plugins/prefilter.i18n');
            $smarty->register_prefilter('smarty_prefilter_i18n');
            $this->smarty = $smarty;
        }

        return $this->smarty;
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

    public function getModule($moduleName)
    {
        if (!isset($this->modules[$moduleName])) {
            $moduleClassName = $moduleName . 'Module';
            try {
                fileLoader::load($moduleName . '/' . $moduleClassName);
            } catch (mzzIoException $e) {
                throw new mzzModuleNotFoundException($moduleName);
            }

            //@todo: прикрутить сюда кэширование, чтобы не тыкаться в ФС каждый раз!
            $appModuleClassName = simpleModule::OVERRIDE_PREFIX . ucfirst($moduleName) . 'Module';
            try {
                fileLoader::load($moduleName . '/' . $appModuleClassName);
                $moduleClassName = $appModuleClassName;
            } catch (mzzIoException $e) {}

            $this->modules[$moduleName] = new $moduleClassName();
        }

        return $this->modules[$moduleName];
    }

    /**
     * Возвращает необходимый маппер
     *
     * @param string $module имя модуля
     * @param string $do имя доменного объекта
     * @deprecated use toolkit->getModule($module)->getMapper($do);
     * @return mapper
     */
    public function getMapper($module, $do)
    {
        $mapper = $this->getMapperFromStack($do);
        if (!$mapper) {
            $module = $this->getModule($module);
            return $module->getMapper($do);
        }
        $this->createMapperStack();
        return $mapper;
    }

    /**
     * Возвращает объект для работы с кэшем
     *
     * @return cache
     */
    public function getCache($cacheName = 'default')
    {
        fileLoader::load('cache');
        return cache::factory($cacheName);
    }

    /**
     * Получение валидатора
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
     * Установка валидатора
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
     * Устанавливает объект Request
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
     * Устанавливает объект i18n
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


    public function createMapperStack()
    {
        $this->mapperStack = array();
    }

    public function addMapperToStack($class, $mapper)
    {
        $this->mapperStack[$class] = $mapper;
    }

    public function getMapperFromStack($class)
    {
        return isset($this->mapperStack[$class]) ? $this->mapperStack[$class] : null;
    }

    public function getConfig($config) {
        if (!isset($this->config[$config])) {
            fileLoader::load('simple/simpleConfig');
            $this->config[$config] = new simpleConfig($config);
        }

        return $this->config[$config];
    }
}
?>