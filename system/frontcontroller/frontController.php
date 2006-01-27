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
 * frontController: ��������������� �������
 *
 * @package system
 * @version 0.2
 */

class frontController
{

    /**
     * ����������� ������
     *
     */
    public function __construct()
    {
    }

    /**
     * ��������� ����� �������
     *
     * @return string ��� ������� � ������������ � ���������� ������� � ������
     */
    public function getTemplate()
    {
        $toolkit = systemToolkit::getInstance();

        $httprequest = $toolkit->getRequest();
        $sectionMapper = $toolkit->getSectionMapper();

        $section = $httprequest->getSection();
        $action = $httprequest->getAction();

        $template_name = $sectionMapper->getTemplateName($section, $action);
        if ($template_name === false) {
            // ���� ������ �� ������ - �������� ���������� path � ������ ������
            $rewrite = $toolkit->getRewrite();
            $rewrite->loadRules($section);

            $rewrited_path = $rewrite->process($httprequest->get('path'));

            $httprequest->parse($rewrited_path);

            $section = $httprequest->getSection();
            $action = $httprequest->getAction();

            $template_name = $sectionMapper->getTemplateName($section, $action);
            if ($template_name === false) {
                return false;
            }
        }
        return $sectionMapper->templateNameDecorate($template_name);
    }

}

?>