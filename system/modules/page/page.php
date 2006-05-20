<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * page: page
 *
 * @package page
 * @version 0.1.3
 */

class page extends simple
{
    private $mapper;

    public function __construct($mapper, Array $map)
    {
        $this->mapper = $mapper;
        parent::__construct($map);
    }

    /**
     * Получение объекта JIP
     *
     * @return jip
     */
    public function getJip()
    {
        return parent::getJip('page', 'page', $this->name(), 'page');
    }

    public function section()
    {
        return $this->mapper->section();
    }

    public function name()
    {
        return $this->mapper->name();
    }

}

?>