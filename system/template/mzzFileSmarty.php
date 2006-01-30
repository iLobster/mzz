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
     * Smarty object
     *
     * @var object
     */
    private $smarty;

    /**
     * ��������� ������ � ���������� ���������
     * ����������� ��� ���������� ��������� ��������.
     *
     * @param string $resource
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    public function fetch($resource, $cache_id = null, $compile_id = null, $display = false, mzzSmarty $smarty)
    {
        $this->smarty = $smarty;
        $resource_name = $this->getResourceFileName($resource[1], $this->smarty);

        $template = new SplFileObject($this->smarty->template_dir . '/' . $resource_name, 'r');
        $template = $template->fgets(256);

        $result = $this->smarty->_fetch($resource_name, $cache_id, $compile_id, $display);

        // ���� ������ ������, ���������� ����������
        if ($this->smarty->isActive($template)) {
            $params = $this->smarty->parse($template);
            $smarty->assign($params['placeholder'], $result);
            $result = $this->smarty->fetch($params['main'], $cache_id, $compile_id, $display, $this->smarty);
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
    public function getResourceFileName($name)
    {
        if(!is_file($this->getTemplateDir() . '/' . $name)) {
            $subdir = substr($name, 0, strpos($name, '.'));
            return $subdir . '/' . $name;
        }
        return $name;
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
