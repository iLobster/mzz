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

/**
 * frontController: фронтконтроллер проекта
 * 
 * @package system
 * @version 0.1
 */

class frontController
{
    /**#@+
    * @access private
    * @var string
    */

    /**
    * переменная для хранения имени секции
    */
    private $section = null;

    /**
    * переменная для хранения имени экшна
    */
    private $action = null;
    /**#@-*/


    /**
     * конструктор класса
     *
     * @access public
     * @param string $section имя секции
     * @param string $action имя экшна
     */
    public function __construct($section, $action)
    {
        $this->setSection($section);
        $this->setAction($action);
    }

    /**
     * установка секции
     *
     * @access private
     * @param string $section имя секции
     */
    private function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * получение секции
     *
     * @access private
     * @return string имя секции
     */
    private function getSection()
    {
        return $this->section;
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
     * @return string имя шаблона в соответствии с выбранными секцией и экшном
     */
    public function getTemplate()
    {
        return $this->search();
    }

    /**
     * поиск имени шаблона по имени секции и экшну
     *
     * @access private
     * @return string имя шаблона в соответствии с выбранными секцией и экшном
     */
    private function search()
    {
        $section = $this->getSection();
        $action = $this->getAction();

        if (empty($section)) {
            die('Секция не выбрана');
        }

        if (empty($action)) {
            die('Экшн не выбран');
        }

        // в будущем данный массив заменится каким-нибудь хранилищем
        // например БД
        $arr = array(
        'news' => array(
        'list' => 'act.news.list.tpl',
        'view' => 'act.news.view.tpl'
        )
        );

        if (!isset($arr[$section][$action])) {
            die('У секции ' . $section . ' нет экшна ' . $action);
        }

        return $arr[$section][$action];
    }
}

?>