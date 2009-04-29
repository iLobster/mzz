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
 * configFolder: класс для работы c данными
 *
 * @package modules
 * @subpackage config
 * @version 0.3
 */
class configFolder extends entity
{
    protected $name = 'config';
    protected $options = false;

    public function getOptions()
    {
        if ($this->options === false) {
            $this->options = parent::__call('getOptions', array());
        }

        return $this->options;
    }
}

?>