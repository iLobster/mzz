<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/* фронтконтроллер проекта */

class frontController
{
    /**#@+
    * @access private
    * @var string
    */

    /**
    * переменная для хранения имени модуля
    */
    private $module = null;

    /**
    * переменная для хранения имени экшна
    */
    private $action = null;
    /**#@-*/


    /**
     * конструктор класса
     *
     * @access public
     * @param string $module имя модуля
     * @param string $action имя экшна
     */
    public function __construct($module, $action)
    {
        $this->setModule($module);
        $this->setAction($action);
    }

    /**
     * установка модуля
     *
     * @access private
     * @param string $module имя модуля
     */
    private function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * получение модуля
     *
     * @access private
     * @return string имя модуля
     */
    private function getModule()
    {
        return $this->module;
    }

    /**
     * установка экшна
     *
     * @access private
     * @param $action имя экшна
     */
    private function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * получение экшна
     *
     * @access private
     * @return string имя экшна
     */
    private function getAction()
    {
        return $this->action;
    }

    /**
     * получение имени шаблона
     *
     * @access public
     * @return string имя шаблона в соответствии с выбранными модулем и экшном
     */
    public function getTemplate()
    {
        return $this->search();
    }

    /**
     * поиск имени шаблона по имени модуля и экшну
     *
     * @access private
     * @return string имя шаблона в соответствии с выбранными модулем и экшном
     */
    private function search()
    {
        $module = $this->getModule();
        $action = $this->getAction();

        if (empty($module)) {
            die('Модуль не выбран');
        }

        if (empty($action)) {
            die('Экшн не выбран');
        }

        // в будущем данный массив заменится каким-нибудь хранилищем
        // например БД
        $arr = array(
        'news' => array(
        'list' => 'news.list.tpl',
        'view' => 'news.view.tpl'
        )
        );

        if (!isset($arr[$module][$action])) {
            die('У модуля ' . $module . ' нет экшна ' . $action);
        }

        return $arr[$module][$action];
    }
}

?>