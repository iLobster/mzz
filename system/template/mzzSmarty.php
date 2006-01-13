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
 * mzzSmarty: ����������� Smarty ��� ������ � ���������
 *
 * @version 0.3
 * @package system
 */

fileLoader::load('libs/smarty/Smarty.class');
fileLoader::load('template/IMzzSmarty');

class mzzSmarty extends Smarty
{
    /**
     * �������� ������� ��� ������ � ��������
     *
     * @var array
     */
    protected $mzzResources = array();

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
        /*if(strpos($resource_name, ':')) {
        throw new mzzSystemException('��������� ������ �������� Smarty �� �����������. �� ����������� "file:" � ������ ��������.');
        }*/
        $resource = explode(':', $resource_name, 2);

        if(count($resource) === 1) {
            $resource = array($this->default_resource_type, $resource_name);
        }

        $mzzname = 'mzz' . ucfirst($resource[0]) . 'Smarty';

        fileLoader::load('template/' . $mzzname);
        if(!class_exists($mzzname)) {
            $error = sprintf("Can't find class '%s' for template engine", $mzzname);
            throw new mzzRuntimeException($error);
            return false;
        }

        if(!isset($this->mzzResources[$mzzname])) {
            $this->mzzResources[$mzzname] = new $mzzname;
        }
        $result = $this->mzzResources[$mzzname]->fetch($resource, $cache_id, $compile_id, $display, $this);

        return $result;

    }

    public function _fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
        $result = parent::fetch($resource_name, $cache_id, $compile_id, $display, $this);
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
        if (preg_match('/\{\*\s*(.*?)\s*\*\}/', $str, $clean_str)) {
            $clean_str = preg_split('/\s+/', $clean_str[1]);
            foreach ($clean_str as $str) {
                $temp_str = explode('=', $str);
                $params[$temp_str[0]] = str_replace(array('\'', '"'), '', $temp_str[1]);
            }
        }
        return $params;
    }

}

?>
