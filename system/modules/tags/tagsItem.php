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

    protected $tags = null;

    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function getNewTags()
    {
        return $this->tags;
    }

    public function getTags()
    {
       $rels = $this->getRelations();
       $tags = array();

       foreach ($rels as $rel) {
           $tags[$rel->getTag()->getId()] = $rel->getTag();
       }

       return $tags;
    }

    public function getTagsAsString($glue = ', ')
    {
        $tags = (array) $this->getTags();
        $tmp = array();

        foreach ($tags as $tag) {
            $tmp[] = $tag->getTag();
        }

        return implode($glue, $tmp);
    }

    public function getAcl($action)
    {
        return true;
    }
}

?>