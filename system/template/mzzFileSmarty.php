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
 * @subpackage template
 * @version $Id$
*/

/**
 * mzzFileSmarty: ����������� Smarty ��� ������ � �������-���������
 *
 * @version 0.6
 * @package system
 * @subpackage template
 */
class mzzFileSmarty implements IMzzSmarty
{
    /**
     * Smarty object
     *
     * @var object
     */
    private $smarty;

    /**
     * �����������
     *
     * @param object $smarty
     */
    function __construct(mzzSmarty $smarty)
    {
        $this->smarty = $smarty;
    }

    /**
     * ��������� ������ � ���������� ���������
     *
     * @param string $resource
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    public function fetch($resource, $cache_id = null, $compile_id = null, $display = false)
    {
        $prefix = $this->smarty->getPrefix();
        if (!empty($prefix)) {
            $resource[1] = str_replace('\\', '/', $resource[1]);
            $pos = strrpos($resource[1], '/');
            if ($pos === false) {
                $resource[1] = $prefix . '/' . $resource[1];
            } else {
                $resource[1] = substr($resource[1], 0, $pos + 1) . $prefix . '/' . substr($resource[1], $pos + 1);
            }
        }

        // ��� ����������� ��������� ��������� ���������� ��������� ������ 256 ������ �� �������
        $fileName = $this->getTemplateDir() . DIRECTORY_SEPARATOR . $resource[1];
        if (!file_exists($fileName)) {
            throw new mzzRuntimeException("������ <em>'" . $fileName . "'</em> �����������.");
        }
        $template = new SplFileObject($fileName, 'r');
        $template = $template->fgets(256);

        $result = $this->smarty->fetchPassive($resource[1], $cache_id, $compile_id, $display);

        // ���� ������ ������, ���������� ����������
        if ($this->smarty->isActive($template)) {
            $result = $this->smarty->fetchActive($template, $cache_id, $compile_id, $display, $result);
        }
        return $result;

    }


    /**
     * ���������� ���������� � ����������� ��������
     *
     * @return string ���������� ����
     */
    public function getTemplateDir()
    {
        return $this->smarty->template_dir;
    }

}

?>