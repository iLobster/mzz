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
 * config: ����� ��� ������ � �������������
 *
 * @package system
 * @version 0.2
*/
class config
{
    /**
     * �������� ��� �������� ���������� ��������� ������-�����
     *
     * @var array
     * @access protected
     */
    protected $_ini;

    /**
     * ��� ������������� ������-�����
     *
     * @var string
     * @access protected
     */
    protected $_ini_file;

    /**
     * Constructor
     *
     * @access public
     * @return void
     */
    public function __construct() {

    }

    /**
     * �������� � ��������� ������-�����. ��������� ��������� ����������� � ���
     * ��������� ������ ������ load � ��� �� ������ ������-����� ����� ���������
     * ����������� ���������. ��� ���������� ���������� ������������ ����� update.
     *
     * @access public
     * @param string $file ��� ����� (��� '.ini' � �����)
     * @param boolean $process_sections
     * @return bolean
     */
    public function load($file, $process_sections = true)
    {
        $file = fileLoader::resolve('configs/'.$file.'.ini');
        if(!isset($this->_ini_file) || $this->_ini_file != $file) {
            if(($this->_ini = parse_ini_file($file, $process_sections)) !== false) {
                $this->_ini_file = $file;
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }

    }

    /**
     * ��������� �������� �����
     *
     * @access public
     * @param string $section ��� ������
     * @param string $name ��� �����
     * @return string|false
     */
    public function getOption($section, $name)
    {
        if(isset($this->_ini[$section][$name])) {
            return $this->_ini[$section][$name];
        } else {
            return false;
        }

    }

    /**
     * ��������� ���� ������
     *
     * @access public
     * @param string $section ��� ������
     * @return array|false
     */
    public function getSection($section)
    {
        if(isset($this->_ini[$section])) {
            return $this->_ini[$section];
        } else {
            return false;
        }
    }

    /**
     * ���������� ���������� ���������
     *
     * @access public
     * @return void
     */
    public function update() {
        $file = $this->_ini_file;
        unset($this->_ini_file);
        $this->load($file);
    }

}

?>