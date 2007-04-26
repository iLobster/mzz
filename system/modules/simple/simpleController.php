<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * simpleController: ���������� ����� ������� � ������������
 *
 * @package modules
 * @subpackage simple
 * @version 0.2.4
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
     * ��������� ��� ������������� ���������� ��������.
     * ���� null, ��������� ������� �� ������������ ��������
     *
     * @var string
     */
    protected $confirm = null;

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
    abstract protected function getView();

    /**
     * ������ �����������. ���� � ������������ �������� ������� �������� confirm, �������
     * ������������� �� ������������ ���������� ������� ���������. ����� ��������� ����� ���������
     * � �������� �������� confirm ��� � �������� ������� ����������� $confirm
     * �������� $confirm
     *
     * @return mixed
     */
    public function run()
    {
        $confirm = $this->toolkit->getRegistry()->get('confirm');
        $confirmCode = $this->request->get('_confirm', 'string', SC_GET);
        $session = $this->toolkit->getSession();

        if (!empty($confirm) && (empty($confirmCode) || $confirmCode != $session->get('confirm_code'))) {
            $session->set('confirm_code', $code = md5(microtime()));
            $url = $this->request->getRequestUrl();
            $url = $url . (strpos($url, '?') ? '&' : '?') . '_confirm=' . $code;

            $this->smarty->assign('url', $url);
            $confirm = empty($this->confirm) ? $confirm : $this->confirm;
            $this->smarty->assign('message', $confirm);
            return $this->smarty->fetch('simple/confirm.tpl');
        }
        if (!empty($confirmMsg)) {
            $session->destroy('confirm_code');
        }
        return $this->getView();
    }

    /**
     * ����� ��������� �������� ��� ���������� ��������� ��������
     *
     * @param simpleMapper $item ������, ������� ���������� ��������� ��������� ��������
     * @param integer $per_page ����� �������� �� ��������
     * @param boolean $reverse ����, ���������� ������� ������� �� ��������������� (�� ������� � �������)
     * @return pager
     */
    protected function setPager($item, $per_page = 20, $reverse = false, $roundItems = 2)
    {
        fileLoader::load('pager');
        $pager = new pager($this->request->getRequestUrl(), $this->request->get('page', 'integer', SC_GET), $per_page, $roundItems, $reverse);
        $item->setPager($pager);

        $this->smarty->assign('pager', $pager);

        return $pager;
    }
}

?>