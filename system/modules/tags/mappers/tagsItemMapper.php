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

fileLoader::load('tags/tagsItem');

/**
 * itemMapper: маппер
 *
 * @package modules
 * @subpackage tags
 * @version 0.2
 */

class tagsItemMapper extends simpleMapper
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
    protected $className = 'tagsItem';
    protected $obj_id_field = null;

    /**
     * Сохранение тегов для объекта. При этом создаются теги, которых еще не было, удаляются
     * теги, которых нет в новом наборе.
     *
     * @param tagsItem $tagsItem
     * @param object $user
     * @return boolean
     */
    public function save($tagsItem, $user = null)
    {
        parent::save($tagsItem, $user);
        $tags = $tagsItem->getNewTags();
        if (is_null($tags)) {
            return false;
        }
        $toolkit = systemToolkit::getInstance();
        $tagsMapper = $toolkit->getMapper('tags', 'tags', 'tags');
        $tagsItemRelMapper = $toolkit->getMapper('tags', 'tagsItemRel', 'tags');

        // новый набор тегов
        $tags = $tagsMapper->saveTags($tags);
        $newTagsKeys = array_keys($tags);

        // текущий набор тегов
        $itemTagsPlain = array();
        $itemTags = $tagsItem->getTags();
        $oldTagsKeys = array_keys($itemTags);
        foreach ($itemTags as $t) {
            $itemTagsPlain[] = $t->getTag();
        }

        // удаляем теги для объекта
        $deletedKeys = array_diff($oldTagsKeys, $newTagsKeys);
        foreach ($deletedKeys as $key) {
            $tagsItemRelMapper->deleteByTagAndItem($key, $tagsItem);
        }

        // создаем связь между и объектом и новыми для него тегов
        $addedKeys = array_diff($newTagsKeys, $oldTagsKeys);
        foreach ($addedKeys as $key) {
            $tagItemRel = $tagsItemRelMapper->create();
            $tagItemRel->setTag($tags[$key]);
            $tagItemRel->setItem($tagsItem->getId());
            $tagsItemRelMapper->save($tagItemRel);
        }
    }

    /**
     * Метод для возврата контроллера, обрабатывающего ошибку 404
     *
     * @return simpleController
     *
     * @todo подумать - насколько это плохо
     */
    public function get404()
    {
        fileLoader::load('tags/controllers/tags404Controller');
        return new tags404Controller();
    }

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        $toolkit = systemToolkit::getInstance();
        $action = $toolkit->getRequest()->getAction();

        if (isset($args['item_id']) || isset($args['id'])) {
            $item_id = isset($args['item_id']) ? $args['item_id'] : $args['id'];
        } else {
            if ($action == 'tagsCloud') {
                $obj_id = $toolkit->getObjectId($this->section . '_' . $action);
                $this->register($obj_id, 'tags', 'tagsItem');
            } else {
                $obj_id = $toolkit->getObjectId($this->section . '_' . $this->className);
                $this->register($obj_id, 'tags');
            }

            $obj = $this->create();
            $obj->import(array('obj_id' => $obj_id));
            return $obj;
        }

        return $this->getTagsItem($item_id);
    }

    /**
     * Возвращает tagsItem. Если его нет, то создает
     *
     * @param integer $item_obj_id
     * @param boolean $autoCreate указывает создавать ли объект, если такого не существует
     * @return tagsItem
     */
    public function getTagsItem($item_obj_id, $autoCreate = true)
    {
        $identifier = 'tagsItem' . $item_obj_id;
        $cache = systemToolkit::getInstance()->getCache();

        if (is_null($tagsItem = $cache->get($identifier))) {
            $tagsItem = $this->searchByItem($item_obj_id);
            if($autoCreate && is_null($tagsItem)) {
                $tagsItem = $this->create();
                $tagsItem->setItemObjId($item_obj_id);
                $this->save($tagsItem);
            }

            $cache->set($identifier, serialize($tagsItem));
        } else {
            $tagsItem = unserialize($tagsItem);
        }

        return $tagsItem;
    }

    /**
     * Извлекает с помощью маппера объектов идентфикаторы этих объектов
     *
     * @param simpleMapper $mapper
     * @return array
     */
    public function getObjIdsFromItemsMapper($mapper)
    {
        if ($mapper instanceof iTaggable) {
            return $mapper->getTaggedObjIds();
        }

        $criteria = new criteria($mapper->getTable(), 't');
        $criteria->addSelectField('obj_id');
        $s = new simpleSelect($criteria);
        return $this->db->getAll($s->toString(), PDO::FETCH_COLUMN);
    }

    /**
     * Ищет tagsItem по obj_id
     *
     * @param integer $obj_id
     * @return tagsItem
     */
    public function searchByItem($obj_id)
    {
        return $this->searchOneByField('item_obj_id', (int) $obj_id);
    }
}

?>