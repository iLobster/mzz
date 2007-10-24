<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/codegenerator/templates/do.tpl $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: do.tpl 1790 2007-06-07 09:48:45Z mz $
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


}

?>