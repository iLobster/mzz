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
 * stdToolkit: стандартный Toolkit
 *
 * @package system
 * @version 0.1.1
 */
class stdToolkit extends toolkit
{
    /**#@+
     * @var object
     */
    private $request;
    private $smarty;
    private $rewrite;
    private $config;
    private $sectionMapper;
    private $timer;
    private $actions;
    private $cache;
    /**#@-*/

    /**
     * @var array
     */
    private $actionNames = array();

    /**
     * Конструктор
     *
     * @param object $config объект для работы с конфигурацией
     */
    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
        $this->actionNames = new arrayDataspace($this->actionNames);
    }

    /**
     * Возвращает объект Request
     *
     * @return object
     */
    public function getRequest()
    {
        if(empty($this->request)) {
            fileLoader::load('request/httpRequest');
            $this->request = new HttpRequest(new requestParser());
        }
        return $this->request;
    }

    /**
     * Возвращает объект Smarty
     *
     * @return object
     */
    public function getSmarty()
    {
        if(empty($this->smarty)) {
            fileLoader::load('template/mzzSmarty');
            $this->smarty = new mzzSmarty();
            $this->smarty->template_dir  = systemConfig::$pathToApplication . 'templates';
            $this->smarty->compile_dir   = systemConfig::$pathToTemp . 'templates_c';
            $this->smarty->plugins_dir[] = systemConfig::$pathToSystem . 'template/plugins';
            $this->smarty->debugging = DEBUG_MODE;
        }
        return $this->smarty;
    }

    /**
     * Возвращает объект Rewrite
     *
     * @param string $section
     * @return object
     */
    public function getRewrite($section)
    {
        // может тут передавать путь/аргумент для резолвера аргументом??
        if(empty($this->rewrite)) {
            fileLoader::load('request/rewrite');
            $this->rewrite = new Rewrite(fileLoader::resolve('configs/rewrite.xml'));
        }
        $this->rewrite->loadRules($section);
        return $this->rewrite;
    }

    /**
     * Возвращает объект Config
     *
     * @return object
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Возвращает объект SectionMapper
     *
     * @return object
     */
    public function getSectionMapper()
    {
        if(empty($this->sectionMapper)) {
            fileLoader::load('core/sectionMapper');
            $this->sectionMapper = new sectionMapper(fileLoader::resolve('configs/map.xml'));
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
        if(empty($this->timer)) {
            $this->timer = new timer();
            $this->timer->start();
        }
        return $this->timer;
    }

    public function getAction($module)
    {
        if($this->actionNames->exists($module) == false) {
            $this->actionNames->set($module, new action($module));
        }
        return $this->actionNames->get($module);
    }

    public function getCache()
    {
        if(empty($this->cache)) {
            $this->cache = new Cache(systemConfig::$pathToTemp);
        }
        return $this->cache;
    }

    /**
     * Устанавливает объект Request
     *
     * @return object
     */
    public function setRequest($request)
    {
        $old_request = $this->request;
        $this->request = $request;
        return $old_request;
    }

    /**
     * Устанавливает объект Smarty
     *
     * @return object
     */
    public function setSmarty($smarty)
    {
        $old_smarty = $this->smarty;
        $this->smarty = $smarty;
        return $old_smarty;
    }

    /**
     * Устанавливает объект Rewrite
     *
     * @return object
     */
    public function setRewrite($rewrite)
    {
        $old_rewrite = $this->rewrite;
        $this->rewrite = $rewrite;
        return $old_rewrite;
    }

    /**
     * Устанавливает объект SectionMapper
     *
     * @return object
     */
    public function setSectionMapper($sectionMapper)
    {
        $old_sectionMapper = $this->sectionMapper;
        $this->sectionMapper = $sectionMapper;
        return $old_sectionMapper;
    }


}
?>