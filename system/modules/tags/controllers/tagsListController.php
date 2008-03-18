<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/tags/controllers/tagsListController.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: tagsListController.php 1121 2007-11-30 04:31:39Z zerkms $
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
        $obj_id = $this->request->getInteger('parent_id');
        $coords = $this->request->getBoolean('coords');
        $search = $this->request->getString('tags', SC_POST);
        $section = $this->request->getRequestedSection();

        if ($obj_id == null) {
            $tagsMapper = $this->toolkit->getMapper('tags', 'tags', 'tags');
            $search = str_replace(array('%', '_'), array('\%', '\_'), $search);
            $tags = $tagsMapper->searchByNameLike($search . '%');
        } else {
            $tagsItemMapper = $this->toolkit->getMapper('tags', 'tagsItem', 'tags');
            $tagsItem = $tagsItemMapper->searchOneByField('item_obj_id', $obj_id);
            $tags = $tagsItem->getTags($coords);
        }


        $this->smarty->assign('section', $section);
        $this->smarty->assign('item_obj_id', $obj_id);

        if(empty($tags)) {
            return $this->smarty->fetch('tags/notags.tpl');
        } else {
            $this->smarty->assign('tags', $tags);
            return $this->smarty->fetch('tags/list' . ($obj_id ? '' : 'All') . '.tpl');
        }

    }
}

?>