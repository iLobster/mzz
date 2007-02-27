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
 * simpleCatalogue
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */

abstract class simpleCatalogue extends simple
{
    protected $properties;
    protected $changedProperties;

    public function __construct(Array $map)
    {
        parent::__construct($map);
        $this->properties = new arrayDataspace();
        $this->changedProperties = new arrayDataspace();
    }

    public function importProperties(Array $data)
    {
        $this->changedProperties->clear();
        $this->properties->import($data);
    }

    public function & exportProperties()
    {
        return $this->changedProperties->export();
    }

    public function getProperty($name)
    {
        return $this->properties->get($name);
    }

    public function setProperty($name, $value)
    {
        return $this->changedProperties->set($name, $value);
    }
}

?>