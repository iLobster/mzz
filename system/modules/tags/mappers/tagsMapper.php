<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/tags/mappers/tagsMapper.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: tagsMapper.php 1121 2007-11-30 04:31:39Z zerkms $
 */

fileLoader::load('tags');

/**
 * tagsMapper: маппер
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */

class tagsMapper extends simpleMapper
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
    protected $className = 'tags';

    /**
     * Создание тегов
     *
     * @param array $tags теги, массив
     * @return array of tags
     */
    public function createTags($tags)
    {
        foreach((array)$tags as $tagName) {
            $t = $this->create();
            $t->setTag(trim($tagName));
            $this->save($t);
            $newTags[] = $t;
        }

        return $newTags;
    }

    public function searchByNameLike($name)
    {
        $criteria = new criteria();
        $criteria->add('tag', $name, criteria::LIKE);
        return $this->searchAllByCriteria($criteria);
    }

    /**
     * Поиск тегов
     *
     * @param array $tags теги
     * @return simple
     */
    public function searchTags($tags)
    {
        $criteria = new criteria();
        $criterion = new criterion('tag', $tags, criteria::IN);
        $criteria->add($criterion);
        return $this->searchAllByCriteria($criteria);
    }

    /**
     * Поиск значений obj_id объектов имеющих данный тег/теги
     *
     * @param array $tag теги
     * @return array of obj_id values
     */
    public function searchObjIdByTag($tag)
    {
        // ищем obj_id сущностей у которых есть этот тег
        $criteria = new criteria('tags_tagsItem', 'ti');

        $joinTagItemRel= new criterion('ti.id','tir.item_id', criteria::EQUAL, true);
        $criteria->addJoin('tags_item_rel', $joinTagItemRel, 'tir', criteria::JOIN_INNER);

        $joinTags= new criterion('tir.tag_id','t.id', criteria::EQUAL, true);
        $criteria->addJoin('tags_tags', $joinTags, 't', criteria::JOIN_INNER);

        $criteria->add('t.tag', $tag);
        $criteria->addSelectField('ti.item_obj_id');

        $s = new simpleSelect($criteria);
        //echo "<pre>";var_dump($s->toString());echo "</pre>";

        $obj_ids = $this->db->getAll($s->toString(), PDO::FETCH_COLUMN);

        return $obj_ids;
    }

    /**
     * Присоединение к таблице с тегами таблицы связи и таблицы контейнера
     *
     * @param mixed $items Массив объектов или список obj_id
     * @return array of tags
     */
    protected function joinTagsItem(criteria $criteria)
    {
        $joinTagItemRel= new criterion('tags.id','tir.tag_id', criteria::EQUAL, true);
        $criteria->addJoin('tags_item_rel', $joinTagItemRel, 'tir', criteria::JOIN_INNER);

        $joinTagsItem= new criterion('tir.item_id','ti.id', criteria::EQUAL, true);
        $criteria->addJoin('tags_tagsItem', $joinTagsItem, 'ti', criteria::JOIN_INNER);
    }

    /**
     * Поиск значения повторов самого распространенного тега
     *
     * @param mixed $items Массив объектов или список obj_id
     * @return array of tags
     */
    public function getMaxCount($obj_ids)
    {
        sort($obj_ids);
        $identifier = 'tagMaxCount_' . md5(implode('', $obj_ids));
        $cache = systemToolkit::getInstance()->getCache();
        if(is_null($maxCount = $cache->load($identifier))) {

            $criteria = new criteria($this->table, 'tags');

            $this->joinTagsItem($criteria);

            $objCriterion = new criterion('ti.item_obj_id', $obj_ids, criteria::IN);
            $criteria->add($objCriterion);

            $criteria->addSelectField(new sqlFunction('count', 'tags.id', true), 'count');
            $criteria->addGroupBy('tags.id');
            $criteria->setOrderByFieldDesc('count', false);

            $s = new simpleSelect($criteria);

            $maxCount = (int)$this->db->getOne($s->toString());
            $cache->save($identifier, $maxCount);
        }

        return $maxCount;
    }

    /**
     * Поиск тегов по объектам
     *
     * @param mixed $items Массив объектов или список obj_id
     * @return array of tags
     */
    public function searchAllTagsByItems($items, $limit = null)
    {
        $obj_ids = array();
        foreach ($items as $item) {
            if($item instanceof simple) {
                $obj_ids[] = $item->getObjId();
            } elseif(is_numeric($item)) {
                $obj_ids[] =  $item;
            } else {
                throw new Exception();
                return 1;
            }
        }


        $criteria = new criteria();

        $this->joinTagsItem($criteria);

        $objCriterion = new criterion('ti.item_obj_id', $obj_ids, criteria::IN);
        $criteria->add($objCriterion);

        $criteria->addSelectField('tags.*');
        $criteria->addSelectField(new sqlFunction('count', 'tags.id', true), 'count');
        $criteria->addGroupBy('tags.tag');
        //$criteria->setOrderByFieldAsc('count', false);
        $criteria->setOrderByFieldAsc('tags.tag');

        $s = new simpleSelect($criteria);

        $maxCount = $this->getMaxCount($obj_ids);
        // нет тегов, возвращаем сразу пустой массив
        if($maxCount == 0) {
            return array();
        }

        $stmt = $this->searchByCriteria($criteria);
        $result = array();

        //@fix так как fillArray режет все лишние поля
        while ($row = $stmt->fetch()) {
            foreach ($row as $key => $field) {
                if(strstr($key, self::TABLE_KEY_DELIMITER)) {
                    unset($row[$key]);
                }
            }

            // удельный вес тэга величина линейная, а правильно ли это?
            // если тэг креведко упомянут 1000 раз, а ближайший тэг всего 100, то всё в единицу веса попадет
            // облако потеряет воздушность и адекватность
            //@todo $max(максимальный вес тега) вынести в конфиг
            $max = 5;
            $row['weight'] = round($max * $row['count'] / $maxCount);
            $result[$row[$this->tableKey]] = $this->createItemFromRow($row);
        }

        return $result;
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