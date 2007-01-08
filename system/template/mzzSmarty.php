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
 * @version 0.5.1
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
     * ��� XML-������� � placeholder ������������� runtime
     *
     * @var array
     */
    protected $activeXmlTemplate = false;

    /**
     * Javascript
     *
     * @var array
     */
    protected $javascript = array();

    /**
     * ��������� ������ � ���������� ���������
     * ����������� ��� ���������� ��������� ��������.
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     * @return string
     */
    public function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
        if (!empty($this->javascript)) {
            $this->assign('execute_javascript', $this->javascript);
            $this->javascript = array();
        }
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
            $this->mzzResources[$mzzname] = new $mzzname($this);
        }
        $result = $this->mzzResources[$mzzname]->fetch($resource, $cache_id, $compile_id, $display);

        return $result;

    }

    /**
     * ��������� ��������� ������ � ���������� ���������
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     * @return string
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
     * @return string
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
    public function parse($str)
    {
        if ($this->activeXmlTemplate !== false) {
            $activeXmlTemplate = $this->activeXmlTemplate;
            // ��� �������������� ��������
            $this->activeXmlTemplate = true;
            return $activeXmlTemplate;
        }
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
        $isActive = (strpos($template, "{* main=") === false);
        return ($this->activeXmlTemplate !== true && !$isActive)
               || (is_array($this->activeXmlTemplate));
    }

    /**
     * ������������� �������� XML-������ � placeholder ��� ��������
     *
     * @param string $template_name ��� XML-�������
     * @param string $placeholder ��� placeholder. �� ��������� <i>content</i>
     */
    public function setActiveXmlTemplate($template_name, $placeholder = 'content')
    {
        if (!$this->activeXmlTemplate) {
            $this->activeXmlTemplate = array('main' => $template_name, 'placeholder' => $placeholder);
        }
    }

    /**
     * ���������� true ���� ���������� �������� XML-������
     *
     * @return boolean
     * @see setActiveXmlTemplate()
     */
    public function isXml()
    {
        return $this->activeXmlTemplate !== false;
    }

    /**
     * ��������� � ������ javascript ��� �����������
     * ���������������� ������� � XML-������
     *
     * @param string $javascript javascript
     */
    public function addJavascript($javascript)
    {
        $this->javascript[] = $javascript;
    }
}
?>