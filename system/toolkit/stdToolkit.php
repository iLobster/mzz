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
 * @version 0.2
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
    private $sectionMapper;
    private $timer;
    private $actions;
    private $user;
    private $objectIdGenerator;
    private $mappers = array();
    private $cache;
    /**#@-*/

    /**
     * @var array
     */
    private $actionNames = array();

    /**
     * Конструктор
     *
     */
    public function __construct(/*$config*/)
    {
        parent::__construct();
        /*$this->config = $config;*/
        $this->actionNames = new arrayDataspace($this->actionNames);
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
     * Возвращает объект Response
     *
     * @return object
     */
    public function getResponse()
    {
        if (empty($this->response)) {
            fileLoader::load('request/httpResponse');
            $this->response = new httpResponse($this->getSmarty());
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
            $this->smarty->plugins_dir[] = systemConfig::$pathToSystem . '/template/plugins';
            if (is_dir($appdir = systemConfig::$pathToApplication . '/template/plugins')) {
                $this->smarty->plugins_dir[] = $appdir;
            }
            $this->smarty->debugging = DEBUG_MODE;
            $this->smarty->assign('SITE_PATH', rtrim(SITE_PATH, '/'));
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
                $request = $this->getRequest();
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
     * @todo сделать кэширование
     */
    public function getConfig($section, $module)
    {
        return new config($section, $module);
    }

    /**
     * Возвращает объект SectionMapper
     *
     * @param string $path путь до папки с активными шаблонами. По умолчанию папка_проекта/templates/act/
     * @return object
     */
    public function getSectionMapper($path = null)
    {
        if (empty($this->sectionMapper)) {
            fileLoader::load('controller/sectionMapper');
            if(empty($path)) {
                $path = systemConfig::$pathToApplication . '/templates';
            }
            $this->sectionMapper = new sectionMapper($path);
        }
        return $this->sectionMapper;
    }

    /**
     * Возвращает объект Timer
     *
     * @return object
     */
    public function getTimer()
    {
        if (empty($this->timer)) {
            $this->timer = new timer();
            $this->timer->start();
        }
        return $this->timer;
    }

    /**
     * Возвращает объект Action для модуля $module
     *
     * @param string $module имя модуля
     * @return object
     */
    public function getAction($module)
    {
        if ($this->actionNames->exists($module) == false) {
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
            $userMapper = $this->getMapper('user', 'user', 'user');
            $this->user = $userMapper->searchById(MZZ_USER_GUEST_ID);
        }
        return $this->user;
    }

    /**
     * Возвращает уникальный идентификатор необходимый для идентификации объектов
     *
     * @return integer
     */
    public function getObjectId($name = null)
    {
        if (empty($this->objectIdGenerator)) {
            fileLoader::load('core/objectIdGenerator');
            $this->objectIdGenerator = new objectIdGenerator;
        }
        return $this->objectIdGenerator->generate($name);
    }

    /**
     * Устанавливает объект Request
     *
     * @param object $request
     * @return object
     */
    public function setRequest($request)
    {
        $old_request = $this->request;
        $this->request = $request;
        return $old_request;
    }

    /**
     * Устанавливает объект Response
     *
     * @param object $response
     * @return object
     */
    public function setResponse($response)
    {
        $old_response = $this->response;
        $this->response = $response;
        return $old_response;
    }

    /**
     * Устанавливает объект Session
     *
     * @param object $session
     * @return object
     */
    public function setSession($session)
    {
        $old_session = $this->session;
        $this->session = $session;
        return $old_session;
    }

    /**
     * Устанавливает объект Smarty
     *
     * @param object $smarty
     * @return object
     */
    public function setSmarty($smarty)
    {
        $old_smarty = $this->smarty;
        $this->smarty = $smarty;
        return $old_smarty;
    }

    /**
     * Устанавливает объект requestRouter
     *
     * @param object $router
     * @return object
     */
    public function setRouter($router)
    {
        $old_router = $this->router;
        $this->router = $router;
        return $old_router;
    }

    /**
     * Устанавливает объект SectionMapper
     *
     * @param object $sectionMapper
     * @return object
     */
    public function setSectionMapper($sectionMapper)
    {
        $old_sectionMapper = $this->sectionMapper;
        $this->sectionMapper = $sectionMapper;
        return $old_sectionMapper;
    }

    /**
     * Устанавливает объект пользователя
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
     * Устанавливает объект конфигурации
     *
     * @param object $config
     * @return object
     */
    public function setConfig($config)
    {
        $tmp = $this->config;
        $this->config = $config;
        return $tmp;
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
            $request = $this->getRequest();
            $section = $request->getSection();
        }

        if (!isset($this->mappers[$do][$section])) {
            $mapperName = $do . 'Mapper';
            fileLoader::load($module . '/mappers/' . $mapperName);
            $this->mappers[$do][$section] = new $mapperName($section);
        }

        return $this->mappers[$do][$section];
    }

    public function getCache()
    {
        if (empty($this->cache)) {
            fileLoader::load('cache');
            $this->cache = new cache();
        }

        return $this->cache;
    }
}
?>