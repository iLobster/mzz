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

    public function __construct($mapper, Array $map)
    {
        parent::__construct($mapper, $map);


        $this->properties = new arrayDataspace();
        $this->changedProperties = new arrayDataspace();
        $this->objectType = new arrayDataspace();
    }

    /*
    public function setType($type)
    {
        parent::__call('setType', $type);
    }
    */

    public function importPropsData(Array $data)
    {
        $props = array();
        foreach ($data as $d) {
            if ($d['type'] == 'select') {
                $d['args'] = unserialize($d['args']);
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