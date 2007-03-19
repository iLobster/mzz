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
 * @version 0.2.2
 */

abstract class simpleController
{
    /**
     * Объект Toolkit
     *
     * @var object
     */
    protected $toolkit;

    /**
     * Объект Request
     *
     * @var iRequest
     */
    protected $request;

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
     * Конструктор
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
     * Возвращает объект отображения
     *
     */
    abstract protected function getView();

    /**
     * Запуск контроллера. Если в конфигурации действий указано свойство confirm, требует
     * подтверждения от пользователя выполнения данного сообщения. Текст сообщения может находится
     * в значении свойства confirm или в свойстве объекта контроллера $confirm
     * свойство $confirm
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
            return $this->smarty->fetch('confirm.tpl');
        }
        if (!empty($confirmMsg)) {
            $session->destroy('confirm_code');
        }
        return $this->getView();
    }

    /**
     * Метод установки пейджера для получаемой коллекции объектов
     *
     * @param simpleMapper $item маппер, который возвращает требуемую коллекцию объектов
     * @param string $module имя модуля, которому принадлежит маппер
     * @param string $config_name имя конфигурационной переменной, в которой лежит число объектов на странице
     * @return pager
     */
    protected function setPager($item, $module, $config_name = 'items_per_page')
    {
        $config = $this->toolkit->getConfig($module);
        fileLoader::load('pager');
        $pager = new pager($this->request->getRequestUrl(), $this->request->get('page', 'integer', SC_GET), $config->get($config_name));
        $item->setPager($pager);

        $this->smarty->assign('pager', $pager);

        return $pager;
    }
}

?>