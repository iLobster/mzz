<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('tags/tagsItemRel');

/**
 * tagsItemRelMapper: маппер
 *
 * @package modules
 * @subpackage tags
 * @version 0.2
 */

class tagsItemRelMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'tags';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'tagsItemRel';
    protected $obj_id_field = null;

    /**
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section)
    {
        parent::__construct($section);
        $this->table = 'tags_item_rel';
    }

    public function deleteByTagAndItem($tag_id, $item_id)
    {
        return $this->delete($this->searchByTagAndItem($tag_id, $item_id));
    }

    public function searchByTagAndItem($tag_id, $item_id)
    {
        if ($tag_id instanceof simple) {
            $tag_id = $tag_id->getId();
        }

        if ($item_id instanceof simple) {
            $item_id = $item_id->getId();
        }

        $criteria = new criteria();
        $criteria->add('tag_id', $tag_id);
        $criteria->add('item_id', $item_id);
        return $this->searchOneByCriteria($criteria);
    }

    public function searchByTag($tag_id)
    {
        if ($tag_id instanceof simple) {
            $tag_id = $tag_id->getId();
        }

        $criteria = new criteria();
        $criteria->add('tag_id', $tag_id);
        return $this->searchAllByCriteria($criteria);
    }

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        throw new mzzDONotFoundException();
    }
}

?>