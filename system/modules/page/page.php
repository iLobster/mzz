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
 * page: page
 *
 * @package modules
 * @subpackage page
 * @version 0.1.4
 */
class page extends entity
{

    /**
     * Получение объекта JIP
     *
     * @return jip
     */
   /* public function getJip()
    {
        return $this->getJipView($this->name, $this->getFullPath(), get_class($this));
    }*/
   public function getFullPath()
   {
       $path = $this->getFolder()->getPath() . '/' . $this->getName();
       return substr($path, strpos($path, '/') + 1);
   }
}

?>