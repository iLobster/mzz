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

    protected $itemData;
    protected $propertiesTitles;
    protected $propertiesTypes;

    public function __construct(Array $map)
    {
        parent::__construct($map);
        $this->properties = new arrayDataspace();
        $this->changedProperties = new arrayDataspace();

        $this->itemData = new arrayDataspace();
        $this->propertiesTitles = new arrayDataspace();
        $this->propertiesTypes = new arrayDataspace();
    }

    public function importProperties(Array $data)
    {
        $this->changedProperties->clear();
        $this->properties->import($data);
    }

    public function importServiceData(Array $data)
    {
        $this->propertiesTitles->import($data['titles']);
        $this->propertiesTypes->import($data['types']);
    }

    public function importItemData(Array $data)
    {
        $this->itemData->import($data);
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
        return $this->propertiesTypes->get($name);
    }

    public function getPropertyTitle($name)
    {
        return $this->propertiesTitles->get($name);
    }

    public function setProperty($name, $value)
    {
        return $this->changedProperties->set($name, $value);
    }

    public function getTypeTitle()
    {
        return $this->itemData->get('title');
    }

    public function getTypeName()
    {
        return $this->itemData->get('name');
    }
}
?>