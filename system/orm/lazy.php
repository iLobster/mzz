<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/orm/system/entity.php $
 *
 * MZZ Content Management System (c) 2005-2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: entity.php 2928 2009-01-14 05:53:47Z zerkms $
 */

/**
 * lazy: the class incapsulates information for lazy loading
 *
 * @package system
 * @subpackage orm
 * @version 0.1
 */
class lazy
{
    private $type;
    private $value;
    private $callback;

    public function getValue()
    {
        return ($this->type == "mapperOne" || $this->type == "mapperManyToMany") ? $this->value : null;
    }

    public function __construct(array $data)
    {
        $this->type = 'callback';

        $this->callback = array(
            $data[0],
            $data[1]);
        $this->value = $data[2];
    }

    public function load($args = array())
    {
        $method = 'load' . ucfirst($this->type);
        return $this->$method($args);
    }

    private function loadCallback($args)
    {
        return call_user_func_array($this->callback, array_merge($this->value, $args));
    }
}

?>