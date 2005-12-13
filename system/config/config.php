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
     */
    protected $_ini;

    /**
     * ��� ������������� ������-�����
     *
     * @var string
     */
    protected $_ini_file;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * �������� � ��������� ������-�����. ��������� ��������� ����������� � ���
     * ��������� ������ ������ load � ��� �� ������ ������-����� ����� ���������
     * ����������� ���������. ��� ���������� ���������� ������������ ����� update.
     *
     * @param string $file ��� ����� (��� '.ini' � �����)
     * @param boolean $process_sections
     * @return bolean
     */
    public function load($file, $process_sections = true)
    {
        $file = fileLoader::resolve('configs/' . $file . '.ini');
        if(!isset($this->_ini_file) || $this->_ini_file != $file) {
            if(is_file($file) && ($this->_ini = parse_ini_file($file, $process_sections)) !== false) {
                $this->_ini_file = $file;
                return true;
            } else {
                $error = sprintf("Unable parse config-file '%s'", $file);
                throw new mzzRuntimeException($error);
            }
        } else {
            return true;
        }

    }

    /**
     * ��������� �������� �����
     *
     * @param string $section ��� ������
     * @param string $name ��� �����
     * @return string|false
     */
    public function getOption($section, $name)
    {
        if(isset($this->_ini[$section][$name])) {
            return $this->_ini[$section][$name];
        } else {
            $error = sprintf("Can't find config-option '%s/%s' in '%s'", $section, $name, $this->_ini_file);
            throw new mzzRuntimeException($error);
        }

    }

    /**
     * ��������� ���� ������
     *
     * @param string $section ��� ������
     * @return array|false
     */
    public function getSection($section)
    {
        if(isset($this->_ini[$section])) {
            return $this->_ini[$section];
        } else {
            $error = sprintf("Can't find config-section '%s' in '%s'", $section, $this->_ini_file);
            throw new mzzRuntimeException($error);
        }
    }

    /**
     * ���������� ���������� ���������
     *
     * @return void
     */
    public function update()
    {
        if(isset($this->ini_file)) {
            $file = $this->_ini_file;
            unset($this->_ini_file);
            $this->load($file);
        } else {
            throw new mzzRuntimeException("No found config for update.");
        }

    }
}

?>