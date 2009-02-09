<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * configOption: класс для работы c данными
 *
 * @package modules
 * @subpackage configOption
 * @version 0.1
 */

class configOption extends simple
{
    const TYPE_INT = 1;
    const TYPE_STRING = 2;
    const TYPE_BOOL = 3;
    const TYPE_LIST = 4;

    protected $name = 'configOption';

    public function getTypeTitle()
    {
        $types = $this->mapper->getTypes();
        $type = $this->getType();
        if (!isset($types[$type])) {
            return $types[self::TYPE_INT];
        }

        return $types[$type];
    }
}

?>