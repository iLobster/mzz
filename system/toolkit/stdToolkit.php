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
    /**#@-*/

    /**#@+
     * @var array
     */
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
            $this->smarty = new fSmarty();
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

            $this->smarty->register_object('form', new form());

            fileLoader::load('service/blockHelper');
            $this->smarty->register_object('fblock', $fblock = blockHelper::getInstance());
            $this->smarty->assign('fblock', $fblock);

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
        $module = $this->getModule($module);
        return $module->getMapper($do);
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
}
?>