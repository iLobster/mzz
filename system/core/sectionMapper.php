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
 * sectionMapper: ����� ��� ����������� ����� ������� �� XML-�����
 *
 * @package system
 * @version 0.1
 */
class sectionMapper
{

    /**
     * ��� �������
     *
     * @var array
     * @access protected
     */
    protected $template_name;

    /**
     * Construct
     *
     * @access public
     * @param string $section
     * @param string $action
     */
    public function __construct($section, $action)
    {
        $this->xmlRead($section, $action);
    }

    /**
     * ������ XML-������� � ��������� ��� Mapper.
     *
     * @param string $section
     * @param string $action
     * @return false ���� ��������� ������ ���
     */
    private function xmlRead($section, $action)
    {
        $xml = simplexml_load_file(fileLoader::resolve('configs/mapper.xml'));
        if (!empty($xml->$section)) {
            foreach ($xml->$section->action as $_action) {
                if($_action['name'] == $action) {
                    $this->template_name = (string) $_action;
                    return true;
                }
            }
            $this->template_name = false;
        } else {
            $this->template_name = false;
        }
    }

    /**
     * ��������� ��� ������� (*.tpl)
     *
     * @return string
     */
    public function getTemplateName()
    {
        return $this->template_name;
    }
}

?>
