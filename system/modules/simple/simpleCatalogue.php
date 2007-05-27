<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * simpleCatalogue
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.1
 */
abstract class simpleCatalogue extends simple
{
    protected $properties;
    protected $changedProperties;

    protected $objectType;

    protected $mapper;

    public function __construct($mapper, Array $map)
    {
        parent::__construct($mapper, $map);
        $this->mapper = $mapper;

        $this->properties = new arrayDataspace();
        $this->changedProperties = new arrayDataspace();
        $this->objectType = new arrayDataspace();
    }


    public function setType($type)
    {
        if (!$this->getType()) {
            parent::__call('setType', array($type));
            $this->importPropsData($this->mapper->getProperties($type));
        }
    }


    public function importPropsData(Array $data)
    {
        $props = array();
        foreach ($data as $d) {
            switch ($d['type']) {
                case 'select':
                    $d['args'] = unserialize($d['args']);
                    break;
                case 'dynamicselect':
                    $tmp = unserialize($d['args']);
                    $toolkit = systemToolkit::getInstance();
                    $tmpMapper = $toolkit->getMapper($tmp['module'], $tmp['do'], $tmp['section']);

                    if (!is_callable(array(&$tmpMapper, $tmp['searchMethod']))) {
                        throw new mzzCallbackException(array(&$tmpMapper, $tmp['searchMethod']));
                    }

                    $tmpData = call_user_func_array(array(&$tmpMapper, $tmp['searchMethod']), empty($tmp['params']) ? array() : explode('|', $tmp['params']));
                    $d['args'] = ($tmp['nullElement']) ? array('' => '') : array();
                    foreach ($tmpData as $tmp_do) {
                        $d['args'][$tmp_do->getId()] = $tmp_do->$tmp['extractMethod']();
                    }
                    break;
            }
            $props[$d['name']] = $d;
        }
        $this->properties->import($props);
    }

    public function importProperties(Array $data)
    {
        $props = $this->properties->export();

        foreach ($data as $name => $value) {
            $props[$name]['value'] = isset($props[$name]) ? $value : '';
        }
        $this->properties->import($props);
    }

    public function importTypeData(Array $data)
    {
        $this->objectType->import($data);
    }

    public function & exportProperties()
    {
        return $this->changedProperties->export();
    }

    public function & exportOldProperties()
    {
        return $this->properties->export();
    }

    public function getProperty($name)
    {
        return $this->properties->get($name);
    }

    public function setProperty($name, $value)
    {
        return $this->changedProperties->set($name, $value);
    }

    public function getPropertyValue($name)
    {
        $tmp = $this->properties->get($name);
        return $tmp['value'];
    }

    public function getPropertyType($name)
    {
        $tmp = $this->properties->get($name);
        return $tmp['type'];
    }

    public function getPropertyTitle($name)
    {
        $tmp = $this->properties->get($name);
        return $tmp['title'];
    }

    public function getTypeId()
    {
        return $this->objectType->get('id');
    }

    public function getTypeName()
    {
        return $this->objectType->get('name');
    }

    public function getTypeTitle()
    {
        return $this->objectType->get('title');
    }
}
?>