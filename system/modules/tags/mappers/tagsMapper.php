<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/codegenerator/templates/mapper.tpl $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: mapper.tpl 1998 2007-07-28 20:41:57Z mz $
 */

fileLoader::load('tags');

/**
 * tagsMapper: ������
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */

class tagsMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'tags';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'tags';

    /**
     * �������� �����
     *
     * @param array $tags ����, ������
     * @return array of tags
     */
    public function createTags($tags)
    {
        foreach($tags as $tagName) {
            $t = $this->create();
            $t->setTag(trim($tagName));
            $this->save($t);
            $newTags[] = $t;
        }

        return $newTags;
    }

    /**
     * ����� �����
     *
     * @param array $tags ����
     * @return simple
     */
    public function searchTags($tags)
    {
        $criteria = new criteria();
        $criterion = new criterion('tag', $tags, criteria::IN);
        $criteria->add($criterion);
        $s = new simpleSelect($criteria);
        return $this->searchAllByCriteria($criteria);
    }

    /**
     * ����� �������� obj_id �������� ������� ������ ���/����
     *
     * @param array $tag ����
     * @return array of obj_id values
     */
    public function searchObjIdByTag($tag)
    {
        // ���� obj_id ��������� � ������� ���� ���� ���
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
     * ������������� � ������� � ������ ������� ����� � ������� ����������
     *
     * @param mixed $items ������ �������� ��� ������ obj_id
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
     * ����� �������� �������� ������ ����������������� ����
     *
     * @param mixed $items ������ �������� ��� ������ obj_id
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
     * ����� ����� �� ��������
     *
     * @param mixed $items ������ �������� ��� ������ obj_id
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
        // ��� �����, ���������� ����� ������ ������
        if($maxCount == 0) {
            return array();
        }

        $stmt = $this->searchByCriteria($criteria);
        $result = array();

        //@fix ��� ��� fillArray ����� ��� ������ ����
        while ($row = $stmt->fetch()) {
            foreach ($row as $key => $field) {
                if(strstr($key, self::TABLE_KEY_DELIMITER)) {
                    unset($row[$key]);
                }
            }

            // �������� ��� ���� �������� ��������, � ��������� �� ���?
            // ���� ��� �������� �������� 1000 ���, � ��������� ��� ����� 100, �� �� � ������� ���� �������
            // ������ �������� ����������� � ������������
            //@todo $max(������������ ��� ����) ������� � ������
            $max = 5;
            $row['weight'] = round($max * $row['count'] / $maxCount);
            $result[$row[$this->tableKey]] = $this->createItemFromRow($row);
        }

        return $result;
    }

    /**
     * ���������� �������� ������ �� ����������
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {

        throw new mzzDONotFoundException();
    }
}

?>