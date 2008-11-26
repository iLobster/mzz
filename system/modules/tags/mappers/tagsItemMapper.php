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

        $item_id = isset($args['item_id']) ? $args['item_id'] : $args['id'];
        return $this->getTagsItem($item_id);
    }

    /**
     * Возвращает tagsItem. Если его нет, то создает
     *
     * @param integer $item_obj_id
     * @return tagsItem
     */
    public function getTagsItem($item_obj_id)
    {
        $tagsItem = $this->searchByItem($item_obj_id);

        if(is_null($tagsItem)) {
            $tagsItem = $this->create();
            $tagsItem->setItemObjId($item_obj_id);
            $this->save($tagsItem);
        }

        return $tagsItem;
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