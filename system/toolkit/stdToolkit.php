<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * stdToolkit: ����������� Toolkit
 *
 * @package system
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
    private $rewrite;
    private $config;
    private $sectionMapper;
    private $timer;
    private $actions;
    private $cache;
    private $user;
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
            $this->request = new HttpRequest(new requestParser());
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
            $this->smarty->debugging = DEBUG_MODE;
        }
        return $this->smarty;
    }

    /**
     * ���������� ������ Rewrite
     *
     * @param string $section
     * @return object
     */
    public function getRewrite($section)
    {
        // ����� ��� ���������� ����/�������� ��� ��������� ����������??
        if (empty($this->rewrite)) {
            fileLoader::load('request/rewrite');
            $this->rewrite = new Rewrite(fileLoader::resolve('configs/rewrite.xml'));
        }
        $this->rewrite->loadRules($section);
        return $this->rewrite;
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
     * @return object
     */
    public function getSectionMapper()
    {
        if (empty($this->sectionMapper)) {
            fileLoader::load('core/sectionMapper');
            $this->sectionMapper = new sectionMapper(fileLoader::resolve('configs/map.xml'));
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
     * @return user
     */
    public function getUser()
    {
        if (empty($this->user)) {
            $userMapper = new userMapper('user');
            $this->user = $userMapper->searchById(1);
        }
        return $this->user;
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
     * ������������� ������ Rewrite
     *
     * @param object $rewrite
     * @return object
     */
    public function setRewrite($rewrite)
    {
        $old_rewrite = $this->rewrite;
        $this->rewrite = $rewrite;
        return $old_rewrite;
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
}
?>