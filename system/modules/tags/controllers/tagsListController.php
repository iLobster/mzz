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
        $obj_id = $this->request->get('parent_id', 'integer', SC_PATH);

        $section = $this->request->getRequestedSection();

        $tagsItemMapper = $this->toolkit->getMapper('tags', 'tagsItem', 'tags');
        $tagsItem = $tagsItemMapper->searchOneByField('item_obj_id', $obj_id);

        $tags = $tagsItem->getTags();

        $this->smarty->assign('section', $section);
        $this->smarty->assign('item_obj_id', $obj_id);

        if(empty($tags)) {
            return $this->smarty->fetch('tags/notags.tpl');
        } else {
            $this->smarty->assign('tags', $tagsItem->getTags());
            return $this->smarty->fetch('tags/list.tpl');

        }

    }
}

?>