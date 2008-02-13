<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/tags/tagsItem.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: tagsItem.php 1121 2007-11-30 04:31:39Z zerkms $
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

    protected $tags = null;

    public function setTags($tags)
    {
        if (!is_null($tags)) {
            // парсим тэги
            $tags = explode(',', $tags);
            $tags = array_map('trim', $tags);
            foreach ($tags as $i => $t) {
                if(strlen($t) == 0) {
                    unset($tags[$i]);
                }
            }
        }
        $this->tags = $tags;
    }

    public function getNewTags()
    {
        return $this->tags;
    }

    public function getTags()
    {
        $tagsMapper = systemToolkit::getInstance()->getMapper('tags', 'tags');
        $criteria = new criteria('tags_tags', 'tags');
        $joinRelationCriterion = new criterion('tags.id', 'tags_rel.tag_id', criteria::EQUAL, true);
        $criteria->addJoin('tags_item_rel', $joinRelationCriterion, 'tags_rel', criteria::JOIN_INNER);
        $criteria->add('tags_rel.item_id', $this->getId());

        //$s = new simpleSelect($criteria);
        //echo"<pre>";var_dump($s->toString());echo"</pre>";

        $tags = $tagsMapper->searchAllByCriteria($criteria);
        return $tags;


    }
}

?>