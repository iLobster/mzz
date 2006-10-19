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
 * newsFolder: newsFolder
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class newsFolder extends simple
{
    /**
     * Mapper
     *
     * @var object
     */
    private $mapper;

    protected $name = 'news';

    /**
     * Конструктор
     *
     * @param object $mapper
     * @param array $map
     */
    public function __construct($mapper, Array $map)
    {
        $this->mapper = $mapper;
        parent::__construct($map);
    }

    /**
     * Возвращает children-папки
     *
     * @return array
     */
    public function getFolders()
    {
        if (!$this->fields->exists('folders')) {
            $this->fields->set('folders', $this->mapper->getFolders($this->getParent()));
        }
        return $this->fields->get('folders');
    }

    /**
     * Возвращает объекты, находящиеся в данной папке
     *
     * @return array
     */
    public function getItems()
    {
        if (!$this->fields->exists('items')) {
            $this->fields->set('items', $this->mapper->getItems($this->getParent()));
        }
        return $this->fields->get('items');
    }

    /**
     * установка объекта пейджера в маппере
     *
     * @param pager $pager
     */
    public function setPager($pager)
    {
        $this->mapper->setPager($pager);
    }

    public function getJip()
    {
        return $this->getJipView($this->name, $this->getPath(), get_class($this));
    }
}

?>