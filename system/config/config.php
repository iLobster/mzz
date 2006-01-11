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
 * @version 0.3
*/
class config
{
    /**
     * �������� ��� �������� ���������� ��������� ������-�����
     *
     * @var array
     */
    protected $iniResult;

    /**
     * ���� �� config-�����
     *
     * @var string
     */
    protected $iniFile;

    /**
     * Constructor
     *
     * @param string $configFileName ��� ����� (��� '.ini' � �����)
     */
    public function __construct($configFileName)
    {
        $this->iniFile = $configFileName;
        $this->load();
    }

    /**
     * �������� � ��������� ������-�����.
     *
     */
    public function load()
    {
        if(!is_file($this->iniFile) || ($this->iniResult = parse_ini_file($this->iniFile, true)) === false) {
            $error = sprintf("Unable parse config-file '%s'", $this->iniFile);
            throw new mzzRuntimeException($error);
        }
    }

    /**
     * ��������� �������� �����
     *
     * @param string $sectionName ��� ������
     * @param string $name ��� �����
     * @return string
     */
    public function getOption($sectionName, $name)
    {
        $section = $this->getSection($sectionName);
        if(isset($section[$name])) {
            return $section[$name];
        } else {
            $error = sprintf("Can't find config-option '%s/%s' in '%s'", $sectionName, $name, $this->iniFile);
            throw new mzzRuntimeException($error);
        }

    }

    /**
     * ��������� ���� ������
     *
     * @param string $sectionName ��� ������
     * @return array|false
     */
    public function getSection($sectionName)
    {
        if(isset($this->iniResult[$sectionName])) {
            return $this->iniResult[$sectionName];
        } else {
            $error = sprintf("Can't find config-section '%s' in '%s'", $sectionName, $this->iniFile);
            throw new mzzRuntimeException($error);
        }
    }

}

?>