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
    private $cache;
    private $user;
    private $objectIdGenerator;
    private $xajaxResponse;
    private $mappers = array();
    /**#@-*/

    /**
     * @var array
     */
    private $actionNames = array();

    /**
     * �����������
     *
     */
    public function __construct(/*$config*/)
    {
        parent::__construct();
        /*$this->config = $config;*/
        $this->actionNames = new arrayDataspace($this->actionNames);
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
     * ���������� ������ Response
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
        }
        return $this->smarty;
    }

    /**
     * ���������� ������ requestRouter
     *
     * @param iRequest $request
     * @return object
     */
    public function getRouter($request)
    {
        if (empty($this->router)) {
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
    public function getConfig($section, $module)
    {
        return new config($section, $module);
    }

    /**
     * ���������� ������ SectionMapper
     *
     * @param string $path ���� �� ����� � ��������� ���������. �� ��������� �����_�������/templates/act/
     * @return object
     */
    public function getSectionMapper($path = null)
    {
        if (empty($this->sectionMapper)) {
            fileLoader::load('core/sectionMapper');
            if(empty($path)) {
                $path = systemConfig::$pathToApplication . '/templates/act';
            }
            $this->sectionMapper = new sectionMapper($path);
        }
        return $this->sectionMapper;
    }

    /**
     * ���������� ������ Timer
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
     * ���������� ������ Cache
     *
     * @param object ������ ��� �����������
     * @return object
     */
    public function getCache($object)
    {
        die('cache called');
        if (empty($this->cache)) {
            fileLoader::load('cache');
            $this->cache = true;
        }
        return new cache($object, systemConfig::$pathToTemp . '/cache');
    }

    /**
     * ���������� ������ �������� ������������
     *
     * @param string $alias �����, ����������� �� �� ����� ���������� � �� ������������. ���������� ��� ����������� ������������� ��������������� ������ �� ��������� ����������.
     * @return user
     */
    public function getUser($alias = 'default')
    {
        if (empty($this->user)) {
            $userMapper = $this->getMapper('user', 'user', 'user', $alias);
            $this->user = $userMapper->searchById(MZZ_USER_GUEST_ID);
        }
        return $this->user;
    }

    /**
     * ���������� ���������� ������������� ����������� ��� ������������� DAO ��������
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
     * ���������� xajaxResponse
     *
     * @return object
     */
    public function getXajaxResponse()
    {
        if (empty($this->xajaxResponse)) {
            $this->xajaxResponse = new xajaxResponse;
        }
        return $this->xajaxResponse;
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
     * ������������� ������ SectionMapper
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
    public function getMapper($module, $do, $section, $alias = 'default')
    {
        if (!isset($this->mappers[$alias][$do][$section])) {
            $mapperName = $do . 'Mapper';
            fileLoader::load($module . '/mappers/' . $mapperName);
            $this->mappers[$alias][$do][$section] = new $mapperName($section, $alias);
        }

        return $this->mappers[$alias][$do][$section];
    }
}
?>