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
 * stdToolkit: ����������� Toolkit
 *
 * @package system
 * @subpackage toolkit
 * @version 0.2.3
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
    /**#@-*/

    /**
     * @var array
     */
    private $actionNames = array();

    /**
     * @var array
     */
    private $mappers = array();

    /**
     * �����������
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->actionNames = new arrayDataspace($this->actionNames);

        $this->toolkit = systemToolkit::getInstance();
    }

    /**
     * ���������� ������ Request
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
     * ���������� ������ arrayDataspace
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
     * ���������� ������ Response
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
     * ���������� ������ Session
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
     * ���������� ������ Smarty
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

            fileLoader::load('libs/smarty/plugins/modifier.filesize');
            $this->smarty->register_modifier('filesize', 'smarty_modifier_filesize');
        }
        return $this->smarty;
    }

    /**
     * ���������� ������ requestRouter
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
     * ���������� ������ Config
     *
     * @return object
     * @todo ������� �����������
     */
    public function getConfig($module, $section = null)
    {
        if (is_null($section)) {
            $request = $this->toolkit->getRequest();
            $section = $request->getSection();
        }
        return new config($section, $module);
    }

    /**
     * ���������� ������ Timer
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
     * ���������� ������ Action ��� ������ $module
     *
     * @param string $module ��� ������
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
     * ���������� ������ �������� ������������
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
     * ���������� ���������� ������������� ����������� ��� ������������� ��������
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
     * ������������� ������ Request
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
     * ������������� ������ Response
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
     * ������������� ������ Session
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
     * ������������� ������ Smarty
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
     * ������������� ������ requestRouter
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
     * ������������� ������ ������������
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
     * ������������� ������ ������������
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
     * ���������� ����������� ������
     *
     * @param string $module ��� ������
     * @param string $do ��� ��������� �������
     * @param string $section ��� �������
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