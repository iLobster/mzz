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
 * simpleController: ���������� ����� ������� � ������������
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */
abstract class simpleController
{
    /**
     * ������ Toolkit
     *
     * @var object
     */
    protected $toolkit;

    /**
     * ������ Request
     *
     * @var iRequest
     */
    protected $request;

    /**
     * ������ ���������� ������
     *
     * @var mzzSmarty
     */
    protected $smarty;

    /**
     * �����������
     *
     */
    public function __construct()
    {
        $this->toolkit = systemToolkit::getInstance();
        $this->request = $this->toolkit->getRequest();
        $this->smarty = $this->toolkit->getSmarty();
        $this->response = $this->toolkit->getResponse();

        if ($this->toolkit->getRegistry()->get('isJip') && $this->request->isAjax()) {
            $this->smarty->setActiveXmlTemplate('main.xml.tpl');
            $this->response->setHeader('Content-Type', 'text/xml');
        }
    }

    /**
     * ���������� ������ �����������
     *
     */
    abstract public function getView();
}

?>