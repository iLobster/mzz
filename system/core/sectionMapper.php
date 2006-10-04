<?php
/**
 * ����� ��� ����������� ����� ������� �� XML-�����
 *
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
 * @subpackage core
 * @version $Id$
*/

/**
 * sectionMapper: ����� ��� ����������� ����� ������� �� XML-�����
 *
 * @package system
 * @subpackage core
 */
class sectionMapper
{
    /**
     * ������� �����
     *
     */
    const TPL_PRE = "act.";

    /**
     * ���������� �������
     *
     */
    const TPL_EXT = ".tpl";

    /**
     * XML Result
     *
     * @var object
     */
    protected $xml;

    /**
     * Construct
     *
     * @param string $mapFileName ���� �� ����� ������������
     */
    public function __construct($mapFileName)
    {
        $this->xml = simplexml_load_file($mapFileName);
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
        if (!empty($this->xml->$section)) {
            foreach ($this->xml->$section->action as $_action) {
                if ($_action['name'] == $action) {
                    return (string) $_action;
                }
            }
        }
        return false;
    }

    /**
     * Decorate pattern
     *
     * @param string $templateName
     * @return string
     */
    public function templateNameDecorate($templateName)
    {
        return self::TPL_PRE . $templateName . self::TPL_EXT;
    }

    /**
     * ��������� ����� �������
     *
     * @param string $section
     * @param string $action
     * @return string|false
     */
    public function getTemplateName($section, $action)
    {
        if (($template_name = $this->xmlRead($section, $action)) !== false) {
            return $this->templateNameDecorate($template_name);
        }
        throw new mzzRuntimeException('�� ������ �������� ������ ��� section = <i>"' . $section . '"</i>, action = <i>"' . $action . '"</i>');
    }
}

?>
