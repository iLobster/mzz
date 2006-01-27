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
 * @version 0.1
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
    /**#@-*/

    /**
     * �����������
     *
     * @param object $config ������ ��� ������ � �������������
     */
    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
    }

    /**
     * ���������� ������ Request
     *
     * @return object
     */
    public function getRequest()
    {
        if(empty($this->request)) {
            $this->request = new HttpRequest(new requestParser());
        }
        return $this->request;
    }

    /**
     * ���������� ������ Smarty
     *
     * @return object
     */
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

    /**
     * ���������� ������ Rewrite
     *
     * @return object
     */
    public function getRewrite()
    {
        // ����� ��� ���������� ����/�������� ��� ��������� ����������??
        if(empty($this->rewrite)) {
            $this->rewrite = new Rewrite(fileLoader::resolve('configs/rewrite.xml'));
        }
        return $this->rewrite;
    }

    /**
     * ���������� ������ Config
     *
     * @return object
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * ���������� ������ SectionMapper
     *
     * @return object
     */
    public function getSectionMapper()
    {
        if(empty($this->sectionMapper)) {
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
        if(empty($this->timer)) {
            $this->timer = new timer();
            $this->timer->start();
        }
        return $this->timer;
    }

    /**
     * ������������� ������ Request
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
     * ������������� ������ Smarty
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
     * ������������� ������ Rewrite
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
     * ������������� ������ SectionMapper
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