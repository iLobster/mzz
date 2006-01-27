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
 * frontController: фронтконтроллер проекта
 *
 * @package system
 * @version 0.1
 */

class frontController
{
    /**#@+
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
     * @param string $section имя секции
     */
    private function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * получение секции
     *
     * @return string имя секции
     */
    private function getSection()
    {
        return $this->section;
    }

    /**
     * установка экшна
     *
     * @param $action имя экшна
     */
    private function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * получение экшна
     *
     * @return string имя экшна
     */
    private function getAction()
    {
        return $this->action;
    }

    /**
     * получение имени шаблона
     *
     * @return string имя шаблона в соответствии с выбранными секцией и экшном
     */
    public function getTemplate()
    {
        return $this->search();
    }

    /**
     * поиск имени шаблона по имени секции и экшну
     *
     * @return string имя шаблона в соответствии с выбранными секцией и экшном
     */
    private function search()
    {
       // $section = $this->getSection();
      //  $action = $this->getAction();
        $toolkit = systemToolkit::getInstance();
       $sectionMapper = $toolkit->getSectionMapper();
		/* // хм..... мне казалось мы тогда решили что этот единственный реврайт / -> /news/list будет делать .htaccess??
        if (($template = $sectionMapper->getTemplateName($section, $action)) === false) {
            $config = $toolkit->getConfig();
            $request = $toolkit->getRequest();

            $config->load('common');

            $section = $config->getOption('main', 'default_section');
            $action = $config->getOption('main', 'default_action');

            $request->setAction($action);
            $request->setSection($section);
            */
           // return $sectionMapper->getTemplateName($section, $action);
           return $sectionMapper->getTemplateName();
       /* }

        return $template;*/
    }
}

?>