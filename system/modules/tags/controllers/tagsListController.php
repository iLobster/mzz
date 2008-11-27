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
 * tagsListController: контроллер для метода list модуля tags
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */

class tagsListController extends simpleController
{
    public function getView()
    {
        $obj_id = $this->request->getInteger('item_id');
        $tag_start = $this->request->getString('tag_start', SC_REQUEST);
        $section = $this->request->getRequestedSection();

        if ($obj_id == null) {
            $tagsMapper = $this->toolkit->getMapper('tags', 'tags', 'tags');
            $tag_start = str_replace(array('%', '_'), array('\%', '\_'), $tag_start);
            $tags = strlen($tag_start) > 1 ? $tagsMapper->searchByNameLike($tag_start . '%') : array();
        } else {
            $tagsItemMapper = $this->toolkit->getMapper('tags', 'tagsItem', 'tags');
            $tagsItem = $tagsItemMapper->getTagsItem($obj_id, false);
            $tags = $tagsItem ? $tagsItem->getTags() : array();
        }

        $this->smarty->assign('section', $section);
        $this->smarty->assign('item_obj_id', $obj_id);
        $this->smarty->assign('tags', $tags);

        return $this->smarty->fetch('tags/list' . ($obj_id ? '' : 'All') . '.tpl');
    }
}

?>