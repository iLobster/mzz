<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/tags/tagsItemRel.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: tagsItemRel.php 1121 2007-11-30 04:31:39Z zerkms $
 */

/**
 * tagsItemRel: класс для работы c данными
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */

class tagsItemRel extends simple
{
    protected $name = 'tags';

    protected $tags = array();

    public function setCoords($coords)
    {
        if (is_string($coords)) {
             $coords = explode(',', $coords, 4);
             if (count($coords) === 4) {
                 $coords = array_combine(array('x', 'y', 'w', 'h'), $coords);
             } else {
                 $coords = array();
             }
        }
        $this->coords = array();
        foreach (array('x', 'y', 'w', 'h') as $coord) {
            $this->coords[$coord] = isset($coords[$coord]) ? (int)$coords[$coord] : 0;
        }
    }

    public function getCoords($changed)
    {
        if ($changed) {
            return $this->coords;
        }
        return $this->mapper->getTagCoords($this->getId());
    }
}

?>