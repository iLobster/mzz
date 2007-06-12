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

fileLoader::load('simple/simpleForTree');

/**
 * menu: класс для работы c данными
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menu extends simple
{
    protected $name = 'menu';

    public function searchAllItems()
    {
        $criteria = new criteria;
        $criteria->add('menu_id', $this->getId(), criteria::EQUAL);

        $itemMapper = systemToolkit::getInstance()->getMapper('menu', 'item');
        return $itemMapper->searchAllByCriteria($criteria);
    }
}

?>