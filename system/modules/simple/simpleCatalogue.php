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

    protected $titles;
    protected $types;
    
    public function __construct(Array $map)
    {
        parent::__construct($map);
        $this->properties = new arrayDataspace();
        $this->changedProperties = new arrayDataspace();
        $this->titles = new arrayDataspace();
        $this->types = new arrayDataspace();
    }

    public function importProperties(Array $data)
    {
        $this->changedProperties->clear();
        $this->properties->import($data);
    }
    
    public function importServiceData(Array $data)
    {
        $this->titles->import($data['titles']);
        $this->types->import($data['types']);
    }

    public function & exportProperties()
    {
        return $this->changedProperties->export();
    }

    public function getProperty($name)
    {
        return $this->properties->get($name);
    }

    public function getTitle($name)
    {
        return $this->titles->get($name);
    }
    
    public function getPropertyType($name)
    {
        return $this->types->get($name);
    }
    
    public function setProperty($name, $value)
    {
        return $this->changedProperties->set($name, $value);
    }

    public function & exportOldProperties()
    {
        return $this->properties->export();
    }
}
?>