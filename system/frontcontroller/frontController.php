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
 * @version 0.2
 */

class frontController
{

    /**
     * конструктор класса
     *
     */
    public function __construct()
    {
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
        $toolkit = systemToolkit::getInstance();
        return $toolkit->getSectionMapper()->getTemplateName();
    }
}

?>