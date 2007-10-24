<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/codegenerator/templates/do.tpl $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: do.tpl 1790 2007-06-07 09:48:45Z mz $
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


    function getTags()
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