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
 * mzzFileSmarty: ����������� Smarty ��� ������ � �������-���������
 *
 * @version 0.3
 * @package system
 */

class mzzFileSmarty implements IMzzSmarty
{
    /**
     * ��������� ������ � ���������� ���������
     * ����������� ��� ���������� ��������� ��������.
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    public function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false, mzzSmarty $smarty)
    {
        $resource_name = $this->getResourceFileName($resource_name, $smarty);

        $template = new SplFileObject($smarty->template_dir . '/' . $resource_name, 'r');
        $template = $template->fgets(256);

        $result = $smarty->_fetch($resource_name, $cache_id, $compile_id, $display);

        // ���� ������ ������, ���������� ����������
        if (preg_match("/\{\*\s*main=/i", $template)) {
            $params = $smarty->parse($template);
            $smarty->assign($params['placeholder'], $result);
            $result = $this->fetch($params['main'], $cache_id, $compile_id, $display, $smarty);
        }
        return $result;

    }

    /**
     * �������� � ���������� ������������� ���� � ��������� ��������.
     * ���� ������ ������ ��������� � ����� ����� � ���������, �� ��������� ���,
     * ���� � ����� ���, �� � �������������� ���� ������������ ������ ����� ����� �� �����.
     *
     * ������:
     * <code>
     * news.view.tpl -> news/news.view.tpl
     * main.tpl -> main.tpl
     * </code>
     *
     * @param string $name
     * @return string
     */
    public function getResourceFileName($name, mzzSmarty $smarty)
    {
        if(!is_file($smarty->getTemplateDir() . '/' . $name)) {
            $subdir = substr($name, 0, strpos($name, '.'));
            return $subdir . '/' . $name;
        }
        return $name;
    }

}

?>
