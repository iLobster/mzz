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
 * @version 0.2.4
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
    private $cache;
    private $toolkit;
    private $validator;
    private $userPreferences;
    /**#@-*/

    /**#@+
    * @var array
    */
    private $actionNames = array();
    private $mappers = array();
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
            $this->request = new HttpRequest();
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
            $this->session = new session();
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
            $this->smarty->template_dir  = systemConfig::$pathToApplication . '/templates';
            $this->smarty->compile_dir   = systemConfig::$pathToTemp . '/templates_c';
            if (is_dir($appdir = systemConfig::$pathToApplication . '/template/plugins')) {
                $this->smarty->plugins_dir[] = $appdir;
            }
            $this->smarty->plugins_dir[] = systemConfig::$pathToSystem . '/template/plugins';

            $this->smarty->debugging = DEBUG_MODE;
            $this->smarty->assign('SITE_PATH', rtrim(SITE_PATH, '/'));

            fileLoader::load('template/plugins/modifier.filesize');
            $this->smarty->register_modifier('filesize', 'smarty_modifier_filesize');

            fileLoader::load('forms/form');
            $this->smarty->register_object('form', new form());

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
     * Возвращает объект Config
     *
     * @return object
     */
    public function getConfig($module, $section = null)
    {
        if (is_null($section)) {
            $request = $this->toolkit->getRequest();
            $section = $request->getSection();
        }

        if (empty($this->config[$module][$section])) {
            $this->config[$module][$section] = new config($section, $module);
        }

        return $this->config[$module][$section];
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
            $userMapper = $this->toolkit->getMapper('user', 'user', 'user');
            $this->user = $userMapper->searchById(MZZ_USER_GUEST_ID);
        }

        return $this->user;
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
            $this->objectIdGenerator = new objectIdGenerator;
        }
        return $this->objectIdGenerator->generate($name, $generateNew);
    }

    /**
     * Возвращает необходимый маппер
     *
     * @param string $module имя модуля
     * @param string $do имя доменного объекта
     * @param string $section имя раздела
     * @return simpleMapper
     */
    public function getMapper($module, $do, $section = null)
    {
        if (is_null($section)) {
            $request = $this->toolkit->getRequest();
            $section = $request->getSection();
        }

        if (!isset($this->mappers[$do][$section])) {
            $mapperName = $do . 'Mapper';
            if (!class_exists($mapperName)) {
                fileLoader::load($module . '/mappers/' . $mapperName);
            }
            $this->mappers[$do][$section] = new $mapperName($section);
        }

        return $this->mappers[$do][$section];
    }

    /**
     * Возвращает объект для работы с кэшем
     *
     * @return cache
     */
    public function getCache()
    {
        if (empty($this->cache)) {
            fileLoader::load('cache');
            $this->cache = cache::factory('memory');
        }

        return $this->cache;
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
     * Устанавливает объект пользователя и возвращает установленный ранее
     *
     * @param user $user
     * @return user
     */
    public function setUser($user)
    {
        $tmp = $this->user;
        $this->user = $user;
        return $tmp;
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

        $this->locale = new locale($name);
        setlocale(LC_ALL, $this->locale->getForSetlocale(), $this->locale->getLanguageName());
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

}

?>