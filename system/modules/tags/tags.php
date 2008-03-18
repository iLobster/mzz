<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/tags/tags.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: tags.php 1121 2007-11-30 04:31:39Z zerkms $
 */

/**
 * tags: класс для работы c данными
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */

class tags extends simple
{
    protected $name = 'tags';
    protected $coords = array();

    /**
     * Количество вхождений тега
     *
     * @param array $row массив с данными
     * @return object
     */
    public function getCount()
    {
        $count = $this->fakeFields->get('count');
        return $count;
    }
    /**
     * Вес тега
     *
     * @param array $row массив с данными
     * @return object
     */
    public function getWeight()
    {
        $weight = $this->fakeFields->get('weight');
        return $weight;
    }

    public function setCoords(array $coords)
    {
        $this->coords = $coords;
    }

    public function getCoords()
    {
        return $this->coords;
    }

}

?>