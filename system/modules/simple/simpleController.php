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
 * simpleController: реализация общих методов у контроллеров
 *
 * @package modules
 * @subpackage simple
 * @version 0.2.5
 */

abstract class simpleController
{
    /**
     * Объект Toolkit
     *
     * @var stdToolkit
     */
    protected $toolkit;

    /**
     * Объект Request
     *
     * @var iRequest
     */
    protected $request;

    /**
     * Объект Request
     *
     * @var httpResponse
     */
    protected $response;

    /**
     * Объект шаблонного движка
     *
     * @var mzzSmarty
     */
    protected $smarty;

    /**
     * Сообщение для подтверждения выполнения действия.
     * Если null, сообщение берется из конфигурации действий
     *
     * @var string
     */
    protected $confirm = null;

    /**
     * Свойство для хранения языка (берётся из SC_GET)
     *
     * @var integer
     */
    protected $lang_id = null;

    /**
     * Конструктор
     *
     */
    public function __construct()
    {
        $this->toolkit = systemToolkit::getInstance();
        $this->request = $this->toolkit->getRequest();
        $this->smarty = $this->toolkit->getSmarty();
        $this->response = $this->toolkit->getResponse();

        $this->lang_id = $this->request->getInteger('lang_id', SC_GET);
    }

    /**
     * Применение к мапперу текущего языка
     *
     * @param simpleMapper $mapper
     */
    final protected function acceptLang(simpleMapper $mapper)
    {
        $mapper->setLangId($this->lang_id);
    }

    /**
     * Перенаправление пользователя на другую страницу
     *
     * @param string $url
     * @param integer $code 302...307
     */
    public function redirect($url, $code = 302)
    {
        $this->smarty->disableMain();
        $this->response->redirect($url, $code);
    }

    /**
     * Возвращает объект отображения
     *
     */
    abstract protected function getView();

    /**
     * Запуск контроллера. Если в конфигурации действий указано свойство confirm, требует
     * подтверждения от пользователя выполнения данного сообщения. Текст сообщения может находиться
     * в значении свойства confirm или в свойстве объекта контроллера $confirm
     *
     * @return mixed
     */
    public function run()
    {
        $confirm = $this->toolkit->getRegistry()->get('confirm');
        $confirmCode = $this->request->getString('_confirm', SC_GET);
        $session = $this->toolkit->getSession();

        if (!empty($confirm) && (empty($confirmCode) || $confirmCode != $session->get('confirm_code'))) {
            $session->set('confirm_code', $code = md5(microtime()));
            $url = $this->request->getRequestUrl();
            $url = $url . (strpos($url, '?') ? '&' : '?') . '_confirm=' . $code;

            $this->smarty->assign('url', $url);

            $confirm = empty($this->confirm) ? $confirm : $this->confirm;

            if (i18n::isName($confirm)) {
                $confirm = i18n::getMessage($confirm);
            }

            $this->smarty->assign('message', $confirm);
            $this->smarty->assign('method', $this->request->getMethod());
            if ($this->request->isMethod('POST')) {
                $postData = http_build_query($this->request->exportPost());
                $postData = explode('&', $postData);
                $formValues = array();
                foreach($postData as $key => $value) {
                    $formValues[$key] = explode('=', $value);
                    $formValues[$key][0] = urldecode($formValues[$key][0]);
                }
                $this->smarty->assign('formValues', $formValues);
            }
            $view = $this->smarty->fetch('simple/confirm.tpl');
        }
        if (!empty($confirmMsg) && empty($view)) {
            $session->destroy('confirm_code');
        }

        if (empty($view)) {
            $view = $this->getView();
        }

        if ($this->toolkit->getRegistry()->get('isJip') && $this->request->isAjax()) {
            $this->smarty->setXmlTemplate('main.xml.tpl');
            $this->response->setHeader('Content-Type', 'text/xml');
        }
        return $view;
    }

    /**
     * Метод установки пейджера для получаемой коллекции объектов
     *
     * @param simpleMapper $item маппер, который возвращает требуемую коллекцию объектов
     * @param integer $per_page число объектов на странице
     * @param boolean $reverse флаг, изменяющий порядок страниц на противоположный (от больших к меньшим)
     * @param integer $roundItems число выводимых номеров страниц рядом с текущим (Например: ... 4 5 6 _7_ 8 9 10 ... -> $roundItems = 3)
     * @return pager
     */
    public function setPager($item, $per_page = 20, $reverse = false, $roundItems = 2)
    {
        fileLoader::load('pager');
        $pager = new pager($this->request->getRequestUrl(), $this->request->getInteger('page', SC_REQUEST), $per_page, $roundItems, $reverse);
        $item->setPager($pager);

        $this->smarty->assign('pager', $pager);

        return $pager;
    }
}

?>