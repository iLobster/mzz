<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @version $Id$
*/

/**
 * frontController: фронтконтроллер проекта
 *
 * @package system
 * @version 0.4
 */
class frontController
{
    /**
     * iRequest
     *
     * @var iRequest
     */
    protected $request;

    /**
     * sectionMapper
     *
     * @var sectionMapper
     */
    protected $sectionMapper;

    /**
     * конструктор класса
     *
     * @param iRequest $request
     */
    public function __construct($request)
    {
        $toolkit = systemToolkit::getInstance();
        $this->request = $request;
        $this->sectionMapper = $toolkit->getSectionMapper();
    }

    /**
     * получение имени шаблона
     *
     * @return string имя шаблона в соответствии с выбранными секцией и экшном
     */
    public function getTemplate()
    {
        $section = $this->request->getSection();
        $action = $this->request->getAction();
        return $this->sectionMapper->getTemplateName($section, $action);
    }

}

?>