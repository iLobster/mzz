<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * menu: класс для работы c данными
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menu extends entity
{
    protected $name = 'menu';
    protected $items;

    public function getItems()
    {
        if (!is_array($this->items)) {
            $mapper = systemToolkit::getInstance()->getMapper('menu', 'menu');
            $this->items = $mapper->searchItemsById($this->getId());
        }
        return $this->items;
    }

    public function getJip()
    {
        return $this->getJipView($this->name, $this->getName(), get_class($this));
    }
}

?>