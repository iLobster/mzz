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
    private $registry;
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
    /**#@-*/

    /**#@+
     * @var array
     */
    private $actionNames = array();
    private $mappers = array();
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
        $this->actionNames = new arrayDataspace($this->actionNames);

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
            fileLoader::load('request/httpRequest');
            $this->request = new httpRequest();
        }

        return $this->request;
    }

    /**
     * Возвращает объект arrayDataspace
     *
     * @return arrayDataspace
     */
    public function getRegistry()
    {
        if (empty($this->registry)) {
            $this->registry = new arrayDataspace();
        }

        return $this->registry;
    }

    /**
     * Возвращает объект Response
     *
     * @return object
     */
    public function getResponse()
    {
        if (empty($this->response)) {
            fileLoader::load('request/httpResponse');
            $this->response = new httpResponse($this->toolkit->getSmarty());
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
            $this->session = new session(systemConfig::$sessionStorageDrive);
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
            fileLoader::load('template/mzzSmarty');
            $this->smarty = new mzzSmarty();
            $this->smarty->template_dir = systemConfig::$pathToApplication . '/templates';
            $this->smarty->compile_dir = systemConfig::$pathToTemp . '/templates_c';
            $oldPluginsDirs = $this->smarty->plugins_dir;
            $this->smarty->plugins_dir = array();
            if (is_dir($appdir = systemConfig::$pathToApplication . '/template/plugins')) {
                $this->smarty->plugins_dir[] = $appdir;
            }
            $this->smarty->plugins_dir[] = systemConfig::$pathToSystem . '/template/plugins';
            $this->smarty->plugins_dir = array_merge($this->smarty->plugins_dir, $oldPluginsDirs);

            $this->smarty->debugging = DEBUG_MODE;
            $this->smarty->assign('SITE_PATH', rtrim(SITE_PATH, '/'));

            fileLoader::load('template/plugins/modifier.filesize');
            $this->smarty->register_modifier('filesize', 'smarty_modifier_filesize');

            fileLoader::load('forms/form');
            $this->smarty->register_object('form', new form());

            fileLoader::load('service/sideHelper');
            $this->smarty->register_object('side', sideHelper::getInstance());

            fileLoader::load('template/plugins/prefilter.i18n');
            $this->smarty->register_prefilter('smarty_prefilter_i18n');
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
     * Возвращает массив вида ключ => значение с конфигурацией для конкретного модуля
     *
     * @param $module имя модуля
     * @return object ArrayDataspace
     */
    public function getConfig($module)
    {
        if (empty($this->config[$module])) {
            $configOptionsMapper = $this->getMapper('config', 'configOption');
            $this->config[$module] = $configOptionsMapper->getModuleOptions($module);
        }

        return $this->config[$module];
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
     * Возвращает объект с описанием действий конкретного модуля
     *
     * @param string $module имя модуля
     * @return object
     */
    public function getAction($module)
    {
        if (!$this->actionNames->exists($module)) {
            $this->actionNames->set($module, new action($module));
        }

        return $this->actionNames->get($module);
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

    /**
     * Возвращает необходимый маппер
     *
     * @param string $module имя модуля
     * @param string $do имя доменного объекта
     * @return mapper
     */
    public function getMapper($module, $do)
    {
        if (!isset($this->mappers[$do])) {
            $mapperName = $do . 'Mapper';
            if (!class_exists($mapperName)) {
                fileLoader::load($module . '/mappers/' . $mapperName);
            }
            $this->mappers[$do] = new $mapperName();
        }

        return $this->mappers[$do];
    }

    /**
     * Получение контроллера
     *
     * @param string $moduleName имя модуля
     * @param string $actionName имя экшна
     * @return simpleController контроллер
     */
    public function getController($moduleName, $actionName)
    {
        $factory = new simpleFactory($this->getAction($moduleName), $moduleName);
        return $factory->getController($actionName);
    }

    /**
     * Возвращает объект для работы с кэшем
     *
     * @return cache
     */
    public function getCache($cacheName = 'default')
    {
        fileLoader::load('cache');
        try {
            $cache = cache::factory($cacheName);
        } catch (mzzUnknownCacheConfigException $ex) {
            $cache = cache::factory(cache::DEFAULT_CONFIG_NAME);
        }

        return $cache;
    }

    /**
     * Получение валидатора
     *
     * @return formValidator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Установка валидатора
     *
     * @param formValidator $value
     */
    public function setValidator($value)
    {
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
            $this->locale = new locale($name);
        } catch (mzzLocaleNotFoundException $e) {
            if (locale::isExists($name)) {
                throw $e;
            }
            $this->locale = new locale(systemConfig::$i18n);
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

    public function getSectionName($module_name)
    {
        $this->initModulesList();

        if (($key = array_search($module_name, $this->modules)) === false) {
            throw new mzzRuntimeException('No section for the module ' . $module_name);
        }

        return $key;
    }

    public function getModuleName($section_name)
    {
        $this->initModulesList();

        if (!isset($this->modules[$section_name])) {
            throw new mzzRuntimeException('No module for the section ' . $section_name);
        }

        return $this->modules[$section_name];
    }

    public function getSectionsList()
    {
        $this->initModulesList();
        return $this->modules;
    }

    protected function initModulesList()
    {
        if (empty($this->modules)) {
            include(fileLoader::resolve('configs/modules'));
            $this->modules = $modules;
        }
    }
}

?>
