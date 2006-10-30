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

fileLoader::load('libs/smarty/Smarty.class');
fileLoader::load('template/IMzzSmarty');

/**
 * mzzSmarty: ����������� Smarty ��� ������ � ��������� � ���������� ���������
 *
 * @version 0.5
 * @package system
 * @subpackage template
 */
class mzzSmarty extends Smarty
{
    /**
     * �������� ������� ��� ������ � ��������
     *
     * @var array
     */
    protected $mzzResources = array();

    /**
     * ������������ �������. ���������� ��� �������������� ������������ �������� ��������
     *
     * @var array
     */
    protected $fetchedTemplates = array();

    /**
     * ���������� �� �������� ������ ������� � ������
     *
     * @var boolean
     */
    protected $nesting = true;

    /**
     * ��������� ������ � ���������� ���������
     * ����������� ��� ���������� ��������� ��������.
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    public function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
        $resource = explode(':', $resource_name, 2);

        if (count($resource) === 1) {
            $resource = array($this->default_resource_type, $resource_name);
        }

        $mzzname = 'mzz' . ucfirst($resource[0]) . 'Smarty';

        if (!class_exists($mzzname)) {
            fileLoader::load('template/' . $mzzname);
        }

        if (!class_exists($mzzname)) {
            $error = sprintf("Can't find class '%s' for template engine", $mzzname);
            throw new mzzRuntimeException($error);
            return false;
        }

        if (!isset($this->mzzResources[$mzzname])) {
            $this->mzzResources[$mzzname] = new $mzzname;
        }
        $result = $this->mzzResources[$mzzname]->fetch($resource, $cache_id, $compile_id, $display, $this);

        return $result;

    }

    /**
     * ��������� ��������� ������ � ���������� ���������
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    public function fetchPassive($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
        $result = parent::fetch($resource_name, $cache_id, $compile_id, $display);
        return $result;
    }

    /**
     * ��������� �������� ������, �������� placeholder � ���������� ���������
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     * @param string $result ��������� ��������� ��������� ��������� ������� ��� ����������
     */
    public function fetchActive($template, $cache_id = null, $compile_id = null, $display = false, $result = null)
    {
        $params = $this->parse($template);

        if (isset($this->fetchedTemplates[$params['main']])) {
            $error = "Detected recursion. Recursion template: %s. <br> All: <pre>%s</pre>";
            throw new mzzRuntimeException(sprintf($error, $params['main'], print_r($this->fetchedTemplates, true)));
        }

        if (!isset($params['placeholder'])) {
            $error = "Template error. Placeholder is not specified.";
            throw new mzzRuntimeException($error);
        }
        $this->fetchedTemplates[$params['main']] = true;

        $this->assign($params['placeholder'], $result);
        $result = $this->fetch($params['main'], $cache_id, $compile_id, $display);
        return $result;
    }

    /**
     * ��������� ������ � ���������� ���������.
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     */
    public function display($resource_name, $cache_id = null, $compile_id = null)
    {
        $this->fetch($resource_name, $cache_id, $compile_id, true);
    }

    /**
     * ������ ������ ������ ��������� (��������) ��������
     *
     * @param string $str
     * @return array
     */
    public static function parse($str)
    {
        $params = array();
        if (preg_match('/\{\*\s*(.*?)\s*\*\}/', $str, $matches)) {
            $clean_str = preg_split('/\s+/', $matches[1]);
            foreach ($clean_str as $str) {
                $param = explode('=', $str, 2);
                $params[$param[0]] = trim($param[1], '\'"');
            }
        }
        return $params;
    }

    /**
     * ���������� true ���� ������ �������� (������ � ������)
     *
     * @param string $template
     * @return boolean
     */
    public function isActive($template)
    {
        return $this->nesting && (strpos($template, "{* main=") !== false);
    }

    /**
     * ������������� ���������� �� �������� ������ ������� � ������
     *
     * @param boolean $flag
     */
    public function allowNesting($flag)
    {
        $this->nesting = $flag;
    }
}
?>