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
 * @version 0.4
 */
class frontController
{
     /**#@+
     * @var object
     */
    protected $request;
    protected $sectionMapper;
    /**#@-*/

    /**
     * конструктор класса
     *
     */
    public function __construct($request)
    {
        $toolkit = systemToolkit::getInstance();
        $this->request = $request;
        $this->sectionMapper = $toolkit->getSectionMapper();
    }

    /**
     * получение имени шаблона с пост-реврайтингом. Реврайтинг будет выполнен только
     * если предоставленный путь клиентов не существует
     *
     * @return string имя шаблона в соответствии с выбранными секцией и экшном
     */
    public function getTemplate()
    {
        $section = $this->request->getSection();
        $action = $this->request->get('action', 'mixed', SC_PATH);

        $template_name = $this->sectionMapper->getTemplateName($section, $action);
        return $template_name;
    }

}

?>