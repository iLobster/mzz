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
            $this->request = new HttpRequest(new requestParser($this->getRewrite()));
        }
        return $this->request;
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

    public function getRewrite()
    {
        // может тут передавать путь/аргумент для резолвера аргументом??
        if(empty($this->rewrite)) {
            $this->rewrite = new Rewrite(fileLoader::resolve('configs/rewrite.xml'));
        }
        return $this->rewrite;
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