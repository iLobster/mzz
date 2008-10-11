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
 * @version 0.1
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


    public function save($tagsItem, $user = null)
    {
        $tags = $tagsItem->getNewTags();
        if (!is_null($tags)) {
            if (!$tagsItem->isSingle()) {
                $tagsItem->setTags(null);
            }
            $toolkit = systemToolkit::getInstance();
            $tagsPlainLowString = array_map('strtolower', $tags);
            $tagsMapper = $toolkit->getMapper('tags', 'tags', 'tags');
            $tagsItemRelMapper = $toolkit->getMapper('tags', 'tagsItemRel', 'tags');

            // учитывается что если в базе iPod, ввели ipod, IPOD, сохраняется как iPod

            $existedTags = $tagsMapper->searchTags($tags);

            $existedTagsPlain = $currentTagsPlain = $deletedTagsPlain = array();
            $newInBaseTags = $newInBaseTagsPlain = $newTagsPlain = $newTags = array();

            // вычисляем новые теги, которых нет в базе
            if(!empty($existedTags)) {

                // готовим массив с тегами строками
                foreach ($existedTags as $t) {
                    $existedTagsPlain[] = $t->getTag();
                }

                // для поиска новых тегов переводим их нижний регистр
                $existedTagsPlainLowString = array_map('strtolower', $existedTagsPlain);

                // вычисляем новые теги
                foreach ($tagsPlainLowString as $i => $t) {
                    if(!in_array($t, $existedTagsPlainLowString)) {
                        $newInBaseTagsPlain[] = $tags[$i];
                    }
                }
            } else {
                // все теги новые
                $newInBaseTagsPlain = $tags;
            }

            // готовим массив с текущими тегами
            $currentTags = $tagsItem->getTags();
            foreach ($currentTags as $t) {
                $currentTagsPlain[] = $t->getTag();
            }

            // вычисляем удаленные теги
            // @todo а где результаты используется?
            // можно для отмены удаления использовать
            $currentTagsPlainLowString = array_map('strtolower', $currentTagsPlain);
            foreach ($currentTagsPlainLowString as $i => $t) {
                if(!in_array($t, $tagsPlainLowString)) {
                    $deletedTagsPlain[] = $currentTagsPlain[$i];
                }
            }

            // новые для объекта теги
            $newTagsPlainLowString = array_diff($tagsPlainLowString, $currentTagsPlainLowString);
            foreach(array_keys($newTagsPlainLowString) as $key) {
                $newTagsPlain[$key] = $tags[$key];
            }

            // создаем новые для базы теги
            if(!empty($newInBaseTagsPlain)) {
                $newInBaseTags = $tagsMapper->createTags($newInBaseTagsPlain);
            }

            // ищем новые для объекта теги и переводим их в объекты
            $newTags = array();
            if(!empty($newTagsPlain)) {
                foreach ($existedTags as $key => $t) {
                    if(in_array(strtolower($t->getTag()), $newTagsPlainLowString)) {
                        $newTags[$key] = $t;
                    }
                }
            }

            $currentUser = $toolkit->getUser();

            // новые теги = $newInBaseTags + $newTags
            // связываем теги с сущностью
            $allNewTags = array_merge($newInBaseTags, $newTags);
            foreach ($allNewTags as $tag) {
                $tagItemRel = $tagsItemRelMapper->create();
                $tagItemRel->setTag($tag);
                $tagItemRel->setItem($tagsItem);
                $tagsItemRelMapper->save($tagItemRel);
            }

            if (!$tagsItem->isSingle()) {
                // вычисляем удаленные теги
                // удаляем связи
                $currentTagsKeys = array_keys($currentTags);
                $existedTagsKeys = array_keys($existedTags);
                $deletedTagsKeys = array_diff($currentTagsKeys, $existedTagsKeys);

                // @todo подумать о личных, общих тэгах. Что удалять, как удалять?

                if(!empty($deletedTagsKeys)) {
                    foreach($deletedTagsKeys as $key) {
                        $tagsItemRelMapper->deleteByTagAndItem($key, $tagsItem);
                    }
                }
            }

        } else {
            parent::save($tagsItem, $user);
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

        if (isset($args['parent_id']) || isset($args['id'])) {
            $parent_obj_id = isset($args['parent_id']) ? $args['parent_id'] : $args['id'];

        } elseif((isset($args['items']) && $action == 'itemsTagsCloud') || ($action == 'tagsCloud')) {
            // если передается список объектов для облака

            $toolkit = systemToolkit::getInstance();
            $obj_id = $toolkit->getObjectId($this->section . '_' . $action);
            $this->register($obj_id, 'tags', 'tagsItem');

            $obj = $this->create();
            $obj->import(array('obj_id' => $obj_id));
            return $obj;

        } else {
            $toolkit = systemToolkit::getInstance();
            $obj_id = $toolkit->getObjectId($this->section . '_' . $this->className);
            $this->register($obj_id, 'tags');

            $obj = $this->create();
            $obj->import(array('obj_id' => $obj_id));
            return $obj;
        }

        $tagsItem = $this->searchOneByField('item_obj_id', $parent_obj_id);
        if(is_null($tagsItem)) {

            // toDo owner добавить?

            $tagsItem = $this->create();
            $tagsItem->setItemObjId($parent_obj_id);
            $this->save($tagsItem);
        }

        if ($tagsItem) {
            return $tagsItem;
        }


        throw new mzzDONotFoundException();
    }
}

?>