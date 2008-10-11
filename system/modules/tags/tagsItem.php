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

    public function isSingle()
    {
        return $this->single;
    }

    public function getNewTags()
    {
        return $this->tags;
    }


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

        //$criteria->debug();
        return $tags;
    }
}

?>