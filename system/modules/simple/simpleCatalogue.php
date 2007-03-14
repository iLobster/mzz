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

    protected $title;
    protected $properties_titles;
    protected $properties_types;

    public function __construct(Array $map)
    {
        parent::__construct($map);
        $this->properties = new arrayDataspace();
        $this->changedProperties = new arrayDataspace();
        $this->properties_titles = new arrayDataspace();
        $this->properties_types = new arrayDataspace();
    }

    public function importProperties(Array $data)
    {
        $this->changedProperties->clear();
        $this->properties->import($data);
    }

    public function importServiceData(Array $data)
    {
        $this->properties_titles->import($data['titles']);
        $this->properties_types->import($data['types']);
    }

    public function importTitle($title)
    {
        $this->title = $title;
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

    public function getPropertyType($name)
    {
        return $this->properties_types->get($name);
    }

    public function getPropertyTitle($name)
    {
        return $this->properties_titles->get($name);
    }

    public function setProperty($name, $value)
    {
        return $this->changedProperties->set($name, $value);
    }

    public function getTypeTitle()
    {
        return $this->title;
    }
}
?>