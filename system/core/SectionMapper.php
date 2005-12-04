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
 * SectionMapper: ����� ��� ����������� ����� ������� �� XML-�����
 *
 * @package system
 * @version 0.1
 */
class SectionMapper
{

    /**
     * ��� �������
     *
     * @var array
     * @access protected
     */
    protected $template_name;

    /**
     * ������� �����
     */
    const TPL_PRE = "act.";

    /**
     * ���������� �������
     */
    const TPL_EXT = ".tpl";
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
        $xml = simplexml_load_file(FileLoader::resolve('configs/map.xml'));
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
     * Decorate pattern
     *
     * @param string $template_name
     * @return string
     */
    protected function templateNameDecorate($template_name)
    {
        return self::TPL_PRE . $template_name . self::TPL_EXT;
    }

    /**
     * ��������� ����� �������
     *
     * @return string
     */
    public function getTemplateName()
    {
        if($this->template_name === false) {
            return false;
        } else {
            return self::templateNameDecorate($this->template_name);
        }
    }
}

?>
