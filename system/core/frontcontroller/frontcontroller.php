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
    // переменная для хранения имени модуля
    private $module = null;

    // переменная для хранения имени экшна
    private $action = null;


    /**
     * Private constructor
     *
     * @access public
     */
    public function __construct($module, $action)
    {
        $this->setModule($module);
        $this->setAction($action);
    }

    /**
     * Установка модуля
     *
     * @access private
     */
    private function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * Получение модуля
     *
     * @access private
     */
    private function getModule()
    {
        return $this->module;
    }

    /**
     * Установка экшна
     *
     * @access private
     */
    private function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Получение экшна
     *
     * @access private
     */
    private function getAction()
    {
        return $this->action;
    }

    /**
     * Получение имени шаблона
     *
     * @access public
     */
    public function getTemplate()
    {
        return $this->search();
    }

    /**
     * Поиск имени шаблона по имени модуля и экшну
     *
     * @access private
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