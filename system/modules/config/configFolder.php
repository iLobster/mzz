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
 * @version 0.1
 */

class configFolder extends simple
{
    protected $name = 'config';
    protected $options = null;

    public function getOptions()
    {
        if (is_null($this->options)) {
            $this->options = $this->mapper->getOptions($this);
        }

        return $this->options;
    }

    public function getObjId()
    {
        return $this->fakeField('obj_id');
    }
}

?>