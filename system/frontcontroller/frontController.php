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
 * @version 0.3
 */
class frontController
{
     /**#@+
     * @var object
     */
    protected $toolkit;
    protected $request;
    protected $sectionMapper;
    /**#@-*/

    /**
     * конструктор класса
     *
     */
    public function __construct($request)
    {
        $this->toolkit = systemToolkit::getInstance();
        $this->request = $request;
        $this->sectionMapper = $this->toolkit->getSectionMapper();
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
        $action = $this->request->getAction();

        $template_name = $this->sectionMapper->getTemplateName($section, $action);

        if ($template_name === false) {
            $template_name = $this->getRewritedTemplate($section);
            if($template_name == false)
            {
                $section = $this->request->setSection('page');
                $this->request->setParam(0, '404');
                $action = $this->request->setAction('view');
                $template_name = $this->sectionMapper->getTemplateName('notFound', 'view');

                // нужно брать из sectionMapper
                //$template_name = 'act.404.view.tpl';
            }
        }

        return $template_name;
    }

    /**
     * получение имени шаблона с пре-реврайтингом
     *
     * @return string имя шаблона в соответствии с выбранными секцией и экшном
     */
    public function getRewritedTemplate()
    {
        $rewrite = $this->toolkit->getRewrite($this->request->getSection());

        $rewrited_path = $rewrite->process($this->request->get('path'));

        $this->request->import($rewrited_path);

        $section = $this->request->getSection();
        $action = $this->request->getAction();
        return $this->sectionMapper->getTemplateName($section, $action);
    }
}

?>