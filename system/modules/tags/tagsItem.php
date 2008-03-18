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

/**
 * item: класс для работы c данными
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */
class tagsItem extends simple
{
    protected $name = 'tags';

    protected $tag = null;

    protected $coords = null;
/*
    protected $single = false;

    public function setTags($tags)
    {
        if (!is_null($tags)) {
            // парсим тэги
            if ($this->single) {
                $tags = (array)trim($tags);
            } else {
                $tags = explode(',', $tags);
                $tags = array_map('trim', $tags);
                foreach ($tags as $i => $t) {
                    if(strlen($t) < 2) { // @todo minLength?
                        unset($tags[$i]);
                    }
                }
            }
        }
        $this->tags = $tags;
    }

    public function getNewTags()
    {
        return $this->tags;
    }*/


    public function setTag($tag)
    {
        $this->tag = trim($tag);
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function getTags($withCoords = false)
    {
        $tagsMapper = systemToolkit::getInstance()->getMapper('tags', 'tags', 'tags');
        $criteria = new criteria('tags_tags', 'tags');
        $joinRelationCriterion = new criterion('tags.id', 'tags_rel.tag_id', criteria::EQUAL, true);
        $criteria->addJoin('tags_item_rel', $joinRelationCriterion, 'tags_rel', criteria::JOIN_INNER);
        $criteria->add('tags_rel.item_id', $this->getId());
        $tags = $tagsMapper->searchAllByCriteria($criteria);
        if ($withCoords) {
            $criteria = new criteria($this->section . '_item_rel');
            $joinCoordsCriterion = new criterion('tags_item_rel.id', 'tags_coords.rel_id', criteria::EQUAL, true);
            $criteria->addJoin('tags_tagCoords', $joinCoordsCriterion, 'tags_coords', criteria::JOIN_INNER);
            //$criteria->add('rel_id', $tag_ids, criteria::IN);
            $criteria->add('item_id', $this->getId());
            $s = new simpleSelect($criteria);
            $coords = DB::factory()->getAll($s->toString(), PDO::FETCH_ASSOC);
            $tagCoords = array();
            foreach ($coords as $coord) {
                $tagCoords[$coord['tag_id']] = $coord;
            }
            foreach ($tags as $tag) {
                $tag->setCoords($tagCoords[$tag->getId()]);
            }
            unset($coords);
        }

        //$criteria->debug();
        return $tags;
    }

    public function setCoords($coords)
    {
        if (is_string($coords)) {
             $coords = explode(',', $coords, 4);
             if (count($coords) === 4) {
                 $coords = array_combine(array('x', 'y', 'w', 'h'), $coords);
             } else {
                 $coords = array();
             }
        }
        $this->coords = array();
        foreach (array('x', 'y', 'w', 'h') as $coord) {
            $this->coords[$coord] = isset($coords[$coord]) ? (int)$coords[$coord] : 0;
        }
    }

    public function getCoords()
    {
        return $this->coords;
    }
}

?>