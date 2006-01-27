<?php

class stdToolkit extends toolkit
{

    private $request;
    private $smarty;
    private $rewrite;
    private $config;
    private $sectionMapper;
    private $timer;

    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
    }
    public function getRequest()
    {
        if(empty($this->request)) {
            $this->request = new HttpRequest(new requestParser());
        }
        return $this->request;
    }

    public function setRequest($request)
    {
        $old_request = $this->request;
        $this->request = $request;
        return $old_request;
    }

    public function getSmarty()
    {
        if(empty($this->smarty)) {
            $this->smarty = new mzzSmarty();
            $this->smarty->template_dir  = systemConfig::$pathToApplication . 'templates';
            $this->smarty->compile_dir   = systemConfig::$pathToTemp . 'templates_c';
            $this->smarty->plugins_dir[] = systemConfig::$pathToSystem . 'template/plugins';
            $this->smarty->debugging = DEBUG_MODE;
        }
        return $this->smarty;
    }

    public function setSmarty($smarty)
    {
        $old_smarty = $this->smarty;
        $this->smarty = $smarty;
        return $old_smarty;
    }

    public function getRewrite()
    {
        // может тут передавать путь/аргумент для резолвера аргументом??
        if(empty($this->rewrite)) {
            $this->rewrite = new Rewrite(fileLoader::resolve('configs/rewrite.xml'));
        }
        return $this->rewrite;
    }

    public function setRewrite($rewrite)
    {
        $old_rewrite = $this->rewrite;
        $this->rewrite = $rewrite;
        return $old_rewrite;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getSectionMapper()
    {
        if(empty($this->sectionMapper)) {
            $this->sectionMapper = new sectionMapper(fileLoader::resolve('configs/map.xml'));
        }
        return $this->sectionMapper;
    }

    public function setSectionMapper($sectionMapper)
    {
        $old_sectionMapper = $this->sectionMapper;
        $this->sectionMapper = $sectionMapper;
        return $old_sectionMapper;
    }

    public function getTimer()
    {
        if(empty($this->timer)) {
            $this->timer = new timer();
            $this->timer->start();
        }
        return $this->timer;
    }
}
?>